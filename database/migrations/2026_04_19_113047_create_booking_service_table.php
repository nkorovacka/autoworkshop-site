<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Str;

return new class extends Migration
{
    public function up(): void
    {
        if (!Schema::hasTable('booking_service')) {
            Schema::create('booking_service', function (Blueprint $table) {
                $table->id();
                $table->foreignId('booking_id')->constrained()->cascadeOnDelete();
                $table->foreignId('service_id')->constrained()->cascadeOnDelete();
                $table->timestamps();

                $table->unique(['booking_id', 'service_id']);
            });
        }

        if (Schema::hasTable('bookings') && Schema::hasColumn('bookings', 'services')) {
            $services = DB::table('services')->select(['id', 'name'])->get();
            $servicesById = $services->keyBy('id');
            $servicesBySlug = $services->keyBy(fn ($service) => Str::slug($service->name));

            DB::table('bookings')
                ->select(['id', 'services'])
                ->orderBy('id')
                ->chunkById(100, function ($bookings) use ($servicesById, $servicesBySlug) {
                    foreach ($bookings as $booking) {
                        $serviceIds = collect();
                        $rawValue = $booking->services;

                        if (empty($rawValue)) {
                            continue;
                        }

                        $decoded = json_decode($rawValue, true);

                        if (is_array($decoded)) {
                            foreach ($decoded as $value) {
                                if (is_numeric($value) && $servicesById->has((int) $value)) {
                                    $serviceIds->push((int) $value);
                                }
                            }
                        } else {
                            foreach (explode(',', $rawValue) as $value) {
                                $slug = Str::slug(trim($value));
                                $service = $servicesBySlug->get($slug);
                                if ($service) {
                                    $serviceIds->push($service->id);
                                }
                            }
                        }

                        $rows = $serviceIds
                            ->unique()
                            ->values()
                            ->map(fn ($serviceId) => [
                                'booking_id' => $booking->id,
                                'service_id' => $serviceId,
                                'created_at' => now(),
                                'updated_at' => now(),
                            ])
                            ->all();

                        if ($rows !== []) {
                            DB::table('booking_service')->insertOrIgnore($rows);
                        }
                    }
                });

            Schema::table('bookings', function (Blueprint $table) {
                $table->dropColumn('services');
            });
        }
    }

    public function down(): void
    {
        if (Schema::hasTable('bookings') && !Schema::hasColumn('bookings', 'services')) {
            Schema::table('bookings', function (Blueprint $table) {
                $table->text('services')->nullable()->after('time_slot');
            });
        }

        if (Schema::hasTable('bookings') && Schema::hasTable('booking_service') && Schema::hasColumn('bookings', 'services')) {
            $servicesByBooking = DB::table('booking_service')
                ->join('services', 'services.id', '=', 'booking_service.service_id')
                ->select('booking_service.booking_id', 'services.name')
                ->orderBy('booking_service.booking_id')
                ->get()
                ->groupBy('booking_id')
                ->map(fn ($rows) => $rows->pluck('name')->implode(', '));

            foreach ($servicesByBooking as $bookingId => $servicesText) {
                DB::table('bookings')->where('id', $bookingId)->update([
                    'services' => $servicesText,
                ]);
            }
        }

        Schema::dropIfExists('booking_service');
    }
};
