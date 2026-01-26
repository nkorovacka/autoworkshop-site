// Ielādējam axios bibliotēku HTTP pieprasījumiem.
import axios from 'axios';
// Padarām axios pieejamu globāli.
window.axios = axios;

// Noklusētais headeris, lai backend atpazīst AJAX pieprasījumus.
window.axios.defaults.headers.common['X-Requested-With'] = 'XMLHttpRequest';
