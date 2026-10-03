<?php
if (!function_exists('base_url')) {
    function base_url() { 
        return "http://localhost/front-end";
    }
}

if (!function_exists('url_segment')) {
    function url_segment($segment) {
        $url = "http://" . $_SERVER["SERVER_NAME"] . $_SERVER['REQUEST_URI'];
        $base = str_replace(base_url(), "", $url);
        $pecah = explode("/", $base);
        return isset($pecah[$segment]) ? $pecah[$segment] : "";
    }
}

if (!function_exists('potong_text')) {
    function potong_text($tulisan, $count) {
        $length = strlen($tulisan);
        if ($length > $count) {
            $i = $count;
            while ($i != 0 && substr($tulisan, $i, 1) != " ") {
                $i--;
            }
            $tulisan = substr($tulisan, 0, $i) . "...";
        }
        return $tulisan;
    }
}

if (!function_exists('tgljm_full')) {
    function tgljm_full($tanggal) {
        // Format tanggal seperti: 30 Mei 2025, 14:32
        $bulan = array(
            1 => 'Januari', 'Februari', 'Maret', 'April', 'Mei', 'Juni',
            'Juli', 'Agustus', 'September', 'Oktober', 'November', 'Desember'
        );

        $tanggal = date('Y-m-d H:i:s', strtotime($tanggal));
        $pecah = explode(' ', $tanggal);
        $tgl = explode('-', $pecah[0]);
        $jam = substr($pecah[1], 0, 5);

        return $tgl[2] . ' ' . $bulan[(int)$tgl[1]] . ' ' . $tgl[0] . ', ' . $jam;
    }
}
?>
