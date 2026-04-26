<footer class="site-footer">
    <div class="footer-wrapper">
        <div class="footer-column">
            <h4>Salons</h4>
            <p>Auto Detailing Workshop<br>Brīvības iela 123, Rīga</p>
            <p>Darba laiks:<br>Pirmdiena-Piektdiena 9:00-19:00<br>Brīvdienās nestrādājam</p>
        </div>
        <div class="footer-column">
            <h4>Kontakti</h4>
            <ul>
                <li>+371 2000 0000</li>
                <li>info@detailing.lv</li>
                <li>WhatsApp & Telegram</li>
            </ul>
        </div>
        <div class="footer-column">
            <h4>Ātrās saites</h4>
            <ul>
                <li><a href="{{ route('services.index') }}">Pakalpojumi</a></li>
                <li><a href="{{ route('products.index') }}">Produkti</a></li>
                <li><a href="{{ route('offers.index') }}">Piedāvājumi</a></li>
                <li><a href="{{ route('booking.create') }}">Rezervēt vizīti</a></li>
            </ul>
        </div>
        <div class="footer-column">
            <h4>Sekojiet mums</h4>
            <ul>
                <li><a href="#">Instagram</a></li>
                <li><a href="#">Facebook</a></li>
                <li><a href="#">YouTube</a></li>
            </ul>
        </div>
    </div>
    <div class="footer-bottom">
        &copy; {{ date('Y') }} Auto Detailing Workshop. Visas tiesības aizsargātas.
    </div>
</footer>
