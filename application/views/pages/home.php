<!DOCTYPE <!DOCTYPE html>
<html>
<head>
    
    <?php 
        echo $js;
        echo $css;

        //inisialiasi kota berdasarkan ID
        $jakarta ='1642911';
        $singapore = '1880252';
        $bangkok ='1609350';

    ?>
    <title>Iklim</title>
  
</head>
<body>
    <?php 
       echo $header;
      ?>
          <form method="POST">
            <select id="city" name="city">
              <option value="">Pilih Kota</option>
               <option value="Jakarta">Jakarta</option>
                  <option value="Singapore">Singapore</option>
                   <option value="Bangkok">Bangkok</option>
            </select>
            <input type="submit" name="submit">
          </form>
           

      <?php 
      //untuk menentukan kota yang ingin di pilih
      if(isset($_POST['submit'])){
        if(isset($_POST['city'])){
          if($_POST['city']=="Jakarta"){
            $kota = $jakarta;
          }
          elseif ($_POST['city']=="Singapore") {
            $kota = $singapore;
          }
          elseif ($_POST['city']=="Bangkok") {
            $kota = $bangkok;
          }


          //############### Request REST API untuk mengambil data JSON
    $request ='http://api.openweathermap.org/data/2.5/forecast?id='.$kota.'&q=&mode=json&units=metric&cnt=40&appid=271da6b323b05ebaf2b4aaa0f3378f89';
    $response  = file_get_contents($request);
    $jsonobj  = json_decode($response);
    }
    
      ?>
     <table class="table">
      <thead>
        <tr>
          <th scope="col"><?php echo $_POST['city']; ?></th>
          <th scope="col">Suhu</th>
          <th scope="col">Perbedaan</th>
        </tr>
      </thead>
      <tbody>
      <!-- ################# Mengola data JSON OBJECT -->
         <?php  

           $rataRataSuhu=0;
           $rataRataPerbedaan=0;
                    $i=0;
           foreach ($jsonobj as $data) {

               $perbedaan = $jsonobj->list[$i]->main->temp_max - $jsonobj->list[$i]->main->temp_min;
               $rataRataSuhu += $jsonobj->list[$i]->main->temp;
               $rataRataPerbedaan += $perbedaan;
      
               $timestamp= $jsonobj->list[$i]->dt;
               $tanggal = gmdate("Y-m-d", $timestamp);
                 
          
               echo"<tr>
                      <td>".$tanggal."</td>
                      <td>".$jsonobj->list[$i]->main->temp."&#176C</td>
                      <td> ".$perbedaan."&#176C</td>
                    </tr>";

              $i+=8;
      
        }
          ?>
        <tfoot>
            <tr>
              <th>Rata-Rata</th>
              <th><?php echo $rataRataSuhu/5; ?>&#176C</th>
              <th><?php echo $rataRataPerbedaan/5; ?>&#176C</th>
           </tr>
        </tfoot>
          
        </tbody>
    </table>

    <?php 

        }
    ?>

     <?php
      echo $footer;
    ?> 
</body>
</html>