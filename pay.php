<?php
include "config.php";
include "utils.php";
if ($_SERVER['REQUEST_METHOD'] == 'POST')
{
    $fechaCreacionSistema = 'SELECT fechaCreacion FROM `carteras` WHERE cartera = "'.$_POST["cartera"].'" order by fechaCreacion DESC limit 1';

    $dbConn =  connect($db);
    $sql = $dbConn->prepare($fechaCreacionSistema);
    $sql->bindValue(':id', $_GET['id']);
    $sql->execute();
    $fechaC = $sql->fetch(PDO::FETCH_ASSOC);
    echo sizeof($fechaC);
    print_r ($fechaC);
    echo '<br>';
    if($fechaC){//existe usuario
        echo '<br>';
    
        $contador = 'SELECT contador FROM `carteras`  order by fechaCreacion DESC limit 1';

        $dbConn =  connect($db);
        $sql2 = $dbConn->prepare($contador);
        $sql2->bindValue(':id', $_GET['id']);
        $sql2->execute();
        $contadorC = $sql2->fetch(PDO::FETCH_ASSOC);
        
        $hoy = date("Y-m-d H:i:s"); 
        echo '<br>'.$hoy.'<br>';
        $nuevaFecha1 = new DateTime($fechaC['fechaCreacion']);
        $nuevaFecha2 = new DateTime($hoy);
        $interval = $nuevaFecha1->diff($nuevaFecha2);
        //echo $interval->i;
        //echo "<br>";
        if($interval->H == 0 && $interval->i <= 2)
        {  
            header("HTTP/1.1 200 OK");
            echo json_encode('espera 2 minutos');
            exit();
        } else {
            $fechaCreacionSistema2 = 'SELECT fechaCreacion FROM `participntes` WHERE cartera = "'.$_POST["cartera"].'" order by fechaCreacion DESC limit 1';

            $dbConn =  connect($db);
            $sql = $dbConn->prepare($fechaCreacionSistema2);
            $sql->bindValue(':id', $_GET['id']);
            $sql->execute();
            $fechaC2 = $sql->fetch(PDO::FETCH_ASSOC);
            $nuevaFecha12 = new DateTime($fechaC2['fechaCreacion']);
            $nuevaFecha22 = new DateTime($hoy);
            $interval2 = $nuevaFecha12->diff($nuevaFecha22);
            if($interval->H == 0 && $interval->i <= 5) {
                /////////////////////guardar base///////////////////////////////////////////////////////
                $url = 'http://faucetcoin.ezyro.com/post.php';
                $curl = curl_init();
                $hoy = date("Y-m-d H:i:s"); 
                $cartera = $_POST["cartera"];
                //echo 'ssssss';
                //echo intval($contadorC['contador']) + 1;
                $fields = array(
                    'cartera' => $cartera,
                    'fechaCreacion' => $hoy,
                    'contador' => intval($contadorC['contador']) + 1,
                    'premio' => 1
                );
                
                $fields_string = http_build_query($fields);
                
                curl_setopt($curl, CURLOPT_URL, $url);
                curl_setopt($curl, CURLOPT_POST, TRUE);
                curl_setopt($curl, CURLOPT_POSTFIELDS, $fields_string);
                
                $data = curl_exec($curl);
                
                curl_close($curl);
            }
            /////////////////////guardar base2///////////////////////////////////////////////////////
            $url = 'http://faucetcoin.ezyro.com/post2.php';
            $curl = curl_init();
            $hoy = date("Y-m-d H:i:s"); 
            $cartera = $_POST["cartera"];
            //echo 'ssssss';
            //echo intval($contadorC['contador']) + 1;
            $fields = array(
                'cartera' => $cartera,
                'fechaCreacion' => $hoy
            );
            
            $fields_string = http_build_query($fields);
            
            curl_setopt($curl, CURLOPT_URL, $url);
            curl_setopt($curl, CURLOPT_POST, TRUE);
            curl_setopt($curl, CURLOPT_POSTFIELDS, $fields_string);
            
            $data = curl_exec($curl);
            
            curl_close($curl);

            ////////////////////////pagar faucet///////////////////////////////////////////
            $url = 'https://faucetpay.io/api/v1/send';
            $curl = curl_init();
            $hoy = date("Y-m-d H:i:s"); 
            $cartera = $_POST["cartera"];
            //echo 'ssssss';
            //echo intval($contadorC['contador']) + 1;
            $fields = array(
                'api_key' => 'f545a817adfdef4877eaa7330b2b04188dc244ea',
                'amount' => 1,
                'to' => $cartera,
                'currency' => 'BTC'
            );
            
            $fields_string = http_build_query($fields);
            
            curl_setopt($curl, CURLOPT_URL, $url);
            curl_setopt($curl, CURLOPT_POST, TRUE);
            curl_setopt($curl, CURLOPT_POSTFIELDS, $fields_string);
            
            $data = curl_exec($curl);
            
            curl_close($curl);

            header("HTTP/1.1 200 OK");
            echo "AA<br>";
            echo json_encode($data);
            exit();
        }
        
    } else {//nuevo usuario no ahi fecha en el sistema
        $contador = 'SELECT contador FROM `carteras`  order by fechaCreacion DESC limit 1';

        $dbConn =  connect($db);
        $sql2 = $dbConn->prepare($contador);
        $sql2->bindValue(':id', $_GET['id']);
        $sql2->execute();
        $contadorC = $sql2->fetch(PDO::FETCH_ASSOC);
        
        $fechaCreacionSistema2 = 'SELECT fechaCreacion FROM `participntes` WHERE cartera = "'.$_POST["cartera"].'" order by fechaCreacion DESC limit 1';

        $dbConn =  connect($db);
        $sql = $dbConn->prepare($fechaCreacionSistema2);
        $sql->bindValue(':id', $_GET['id']);
        $sql->execute();
        $fechaC2 = $sql->fetch(PDO::FETCH_ASSOC);
        $nuevaFecha12 = new DateTime($fechaC2['fechaCreacion']);
        $nuevaFecha22 = new DateTime($hoy);
        $interval2 = $nuevaFecha12->diff($nuevaFecha22);
        if($interval->H == 0 && $interval->i <= 5) {
            /////////////////////guardar base///////////////////////////////////////////////////////
            $url = 'http://faucetcoin.ezyro.com/post.php';
            $curl = curl_init();
            $hoy = date("Y-m-d H:i:s"); 
            $cartera = $_POST["cartera"];
            //echo 'ssssss';
            //echo intval($contadorC['contador']) + 1;
            $fields = array(
                'cartera' => $cartera,
                'fechaCreacion' => $hoy,
                'contador' => intval($contadorC['contador']) + 1,
                'premio' => 1
            );
            
            $fields_string = http_build_query($fields);
            
            curl_setopt($curl, CURLOPT_URL, $url);
            curl_setopt($curl, CURLOPT_POST, TRUE);
            curl_setopt($curl, CURLOPT_POSTFIELDS, $fields_string);
            
            $data = curl_exec($curl);
            
            curl_close($curl);
        }

        /////////////////////guardar base2///////////////////////////////////////////////////////
        $url = 'http://faucetcoin.ezyro.com/post2.php';
        $curl = curl_init();
        $hoy = date("Y-m-d H:i:s"); 
        $cartera = $_POST["cartera"];
        //echo 'ssssss';
        //echo intval($contadorC['contador']) + 1;
        $fields = array(
            'cartera' => $cartera,
            'fechaCreacion' => $hoy
        );
        
        $fields_string = http_build_query($fields);
        
        curl_setopt($curl, CURLOPT_URL, $url);
        curl_setopt($curl, CURLOPT_POST, TRUE);
        curl_setopt($curl, CURLOPT_POSTFIELDS, $fields_string);
        
        $data = curl_exec($curl);
        
        curl_close($curl);

        ////////////////////////pagar faucet///////////////////////////////////////////
        $url = 'https://faucetpay.io/api/v1/send';
        $curl = curl_init();
        $hoy = date("Y-m-d H:i:s"); 
        $cartera = $_POST["cartera"];
        //echo 'ssssss';
        //echo intval($contadorC['contador']) + 1;
        $fields = array(
            'api_key' => 'f545a817adfdef4877eaa7330b2b04188dc244ea',
            'amount' => 1,
            'to' => $cartera,
            'currency' => 'BTC'
        );
        
        $fields_string = http_build_query($fields);
        
        curl_setopt($curl, CURLOPT_URL, $url);
        curl_setopt($curl, CURLOPT_POST, TRUE);
        curl_setopt($curl, CURLOPT_POSTFIELDS, $fields_string);
        
        $data = curl_exec($curl);
        
        curl_close($curl);

        header("HTTP/1.1 200 OK");
        echo "AA<br>";
        echo json_encode($data);
        exit();
    }
}
function guardar(){
    echo 'fffffffffffffffffffffff';
}
function contador(){
    

}
header("HTTP/1.1 400 Bad Request");
/*

	 */
?>