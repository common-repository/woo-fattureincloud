<?php

// Don't access this directly, please
if (!defined('ABSPATH')) exit;


$fattureincloud_url = "https://api.fattureincloud.it:443/v1/mail/lista";

$api_uid = get_option('api_uid_fattureincloud');
$api_key = get_option('wfic_api_key_fattureincloud');


//print_r($lista_articoli);


$fattureincloud_request = array(

    "api_uid" => $api_uid,
    "api_key" => $api_key,
    "data_inizio" => "01/01/".get_option('woo-fattureincloud-anno-fatture'),
    "data_fine" => "31/12/".get_option('woo-fattureincloud-anno-fatture'),
    "pagina" => 1

);

$ch = curl_init();

curl_setopt($ch, CURLOPT_URL, $fattureincloud_url);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
curl_setopt($ch, CURLOPT_POST, 1);
curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($fattureincloud_request));

$headers = array();
$headers[] = 'Content-Type: application/json';
curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);

$pre_result = curl_exec($ch);
if (curl_errno($ch)) {
    echo 'Error:' . curl_error($ch);
}
curl_close($ch);

$fattureincloud_result_getemail = json_decode($pre_result, true);


/*
$fattureincloud_options = array(
    "http" => array(
        "header" => "Content-type: text/json\r\n",
        "method" => "POST",
        "content" => json_encode($fattureincloud_request)
    ),
);
$fattureincloud_context = stream_context_create($fattureincloud_options);
$fattureincloud_result_getemail = json_decode(file_get_contents($fattureincloud_url, false, $fattureincloud_context), true);

*/

print "<div id=\"email-elenco\">";
print "<h2>Elenco Email Inviate</h2>";

if (is_array($fattureincloud_result_getemail)) {

    if (! in_array("success", $fattureincloud_result_getemail)) {

?>
    <div id="message" class="notice notice-error is-dismissible">
        <p><b>Elenco Email non Scaricato: 

<?php

    echo $fattureincloud_result_getemail['error'];

?>
    </b>
    </div>
<?php

    }

    foreach ($fattureincloud_result_getemail as $value) {

        if (is_array($value)) {

            $count = 0;

            foreach ($value as $value2) {

                //print_r($value2);

                $count = $count + 1;

                print "<b>".$value2['oggetto']."</b><br> 
                          ".$value2['stato_invio']."
                          il ".$value2['data']."<br>
                          Destinatario: ".$value2['destinatario']."<br>
                          Email ".$value2['mail_destinatario']."<br><hr>";
                          // <b>Stato</b> ".$value2['stato_lettura']."<hr>";

                if ($count == 5) {

                    print "<p>numero massimo ( 5 ) di email inviate visualizzabili raggiunto</p>";

                    break;

                } 

            }

        }

    }

}

/*
echo "<pre>";
print_r($fattureincloud_result_getemail);
echo "</pre>";
*/