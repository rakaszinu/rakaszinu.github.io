<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link rel="stylesheet" href="style.css?v=<?php echo time(); ?>">
    <link href="https://fonts.cdnfonts.com/css/gabo-drive" rel="stylesheet">
</head>
<body>
    <nav id="nav-3">
    <a class="link-3" href="ProjektEN.php">Strona główna</a>
    <a class="link-3" href="Kontakt.php">O nas</a>
    <a class="link-3" href="Produkty.php?W=all">Produkty</a>
       
    </nav>

    <a class='koszyk' href='Koszyk.php'><img class='login' src='koszyk.png' ></a>

    <?php
        session_start();

        echo "      <a class='link-4' onclick='myFunction()'><img class='login' src='login.png' ></a>";
        echo "      <div id='topnav'> "  ;
        echo "          <div id='myLinks' style='display: block;'>";
        if(isset($_SESSION['login']))
        {
            if($_SESSION['login']==1)
            {
                echo "<a  style='background-color: white;right: 10px;position: absolute;width: 90px' href='Konto.php'>Konto</a><br>" ;
                echo "<a  style='background-color: white;right: 10px;position: absolute;width: 90px' href='loginy.php?clear=tak'>Wyloguj</a><br>" ;
            }
        }
        else
        {
            echo "              <a  style='background-color: white;right: 10px;position: absolute;width: 90px' href='loginy.php'>Login</a><br>";
            echo "              <a  style='background-color: white;right: 10px;position: absolute;width: 90px' href='loginy.php'>Rejestr</a><br>";
        }  
        echo "          </div>";
        echo "      </div>";
    ?>
    <script>
            var x = document.getElementById("topnav");
            x.style.display = "none"
            function myFunction() {
            if (x.style.display === "block") {
                x.style.display = "none";
            } else {
                x.style.display = "block";
            }
            }
      </script>

    <hr class="linia">
    <?php
    $connect = new mysqli('localhost','root','','loginyen');

    $query="SELECT COUNT(produkt_id) FROM produkt";
    $result1=$connect->query($query);
    while($row1=$result1->fetch_row())
    {
        $all=$row1[0];
    }
    $query="SELECT COUNT(produkt_id) FROM produkt WHERE wydawca_id='1'";
    $result1=$connect->query($query);
    while($row1=$result1->fetch_row())
    {
        $DH=$row1[0];
    }
    $query="SELECT COUNT(produkt_id) FROM produkt WHERE wydawca_id='2'";
    $result1=$connect->query($query);
    while($row1=$result1->fetch_row())
    {
        $M=$row1[0];
    }
    $query="SELECT COUNT(produkt_id) FROM produkt WHERE wydawca_id='3'";
    $result1=$connect->query($query);
    while($row1=$result1->fetch_row())
    {
        $DC=$row1[0];
    }
    $query="SELECT COUNT(produkt_id) FROM produkt WHERE wydawca_id='4'";
    $result1=$connect->query($query);
    while($row1=$result1->fetch_row())
    {
        $I=$row1[0];
    }


    $query = "SELECT COUNT(kategoria_id) FROM `kategoria`";
    $result3 = $connect->query($query);
    if ($result3) {
        while ($row3 = $result3->fetch_row()) {
            $liczba = $row3[0];
        }
    } 

    /*for($i=1;$i<=$liczba;$i++)
    {
        $query="SELECT COUNT(DISTINCT produkty_id) AS liczba_produktow FROM kategoria_produkty  WHERE kategoria_id = '$i' ;";
        $KatL=[];
        $result4=$connect->query($query);
        while($row4=$result4->fetch_assoc())
        {
            $KatL[$i]=$row4['liczba_produktow'];
            echo "$KatL[$i]"."<br>";
        }
    }*/
    $stmt = $connect->prepare("SELECT COUNT(DISTINCT produkt_id) AS liczba_produktow FROM kategoria_produkty WHERE kategoria_id = ?");
    $stmt->bind_param("i", $i);

    for ($i = 1; $i <= $liczba; $i++) {
        $stmt->execute();
        $result4 = $stmt->get_result();

        if ($result4) {
            while ($row4 = $result4->fetch_assoc()) {
                $KatL[$i] = $row4['liczba_produktow'];
            }
        } 
    }

    



    echo "<div class='left-panel'>";
    echo "<div class='wyszukiwanie'>";
    echo "<form action='Produkty.php'>";
    echo "<input type='text' placeholder='Wyszukaj..' name='S'>" ;
    echo "<button type='submit' class='WyszuajPrzycisk'><i class='Wi'>W</i></button>";
    echo "</form>";
    echo "</div>";
    echo " <a class='a' href='Produkty.php?W=all'>Wszystkie(".$all.")</a><br>";
    echo " <a class='a' href='Produkty.php?W=M'>Marvel(".$M.")</a><br>";
    echo " <a class='a' href='Produkty.php?W=DH'>Dark Horse Comisc(".$DH.")</a><br>";
    echo " <a class='a' href='Produkty.php?W=DC'>DC Comics(".$DC.")</a><br>";
    echo " <a class='a' href='Produkty.php?W=I'>INDIE comisc(".$I.")</a><br>";
    echo "<br><br>";
    $query="SELECT * FROM kategoria";
                $kategorie=[];
                $result=$connect->query($query);
                $liczba2=1;
                while($row=$result->fetch_object()){
                   $kategorie[$row->kategoria_id]=$row->nazwa;
                   echo "<a class='a' href='Produkty.php?K=$row->kategoria_id'>$row->nazwa(".$KatL[$row->kategoria_id].")</a><br>";
                   $liczba2++;
                }
    
    echo "</div>";
    ?>

    <div class="kontent">
         <?php
            if(ISSET($_SESSION['admin']))
            {
                If($_SESSION['admin']==1)
                {
                    echo "<a href='Admin.php?dodaj=produkt' class='produkt'><img height='250px' width='200px' src='./Obrazy/Admin.png'><span>Dodaj</span></a>";
                }
            }
            if(ISSET($_GET['W']))
            {
            if($_GET['W']=="all")
            {
                $query="SELECT * FROM produkt";
                $result = $connect->query($query);
                while ($row = $result->fetch_object()) {
                    echo "<a href='produkt.php?id={$row->produkt_id}' class='produkt'>
                            <img height='250px' width='200px' src='./Obrazy/{$row->obraz}'>
                            <span>{$row->nazwa}</span>
                        </a>";
                }
            }
            if($_GET['W']=="M")
            {
                $query="SELECT * FROM produkt WHERE wydawca_id='2'";
                $result = $connect->query($query);
                while ($row = $result->fetch_object()) {
                    echo "<a href='produkt.php?id={$row->produkt_id}' class='produkt'>
                            <img height='250px' width='200px' src='./Obrazy/{$row->obraz}'>
                            <span>{$row->nazwa}</span>
                        </a>";
                }
            }
            if($_GET['W']=="DH")
            {
                $query="SELECT * FROM produkt WHERE wydawca_id='1'";
                $result = $connect->query($query);
                while ($row = $result->fetch_object()) {
                    echo "<a href='produkt.php?id={$row->produkt_id}' class='produkt'>
                            <img height='250px' width='200px' src='./Obrazy/{$row->obraz}'>
                            <span>{$row->nazwa}</span>
                        </a>";
                }
            }
            if($_GET['W']=="DC")
            {
                $query="SELECT * FROM produkt WHERE wydawca_id='3'";
                $result = $connect->query($query);
                while ($row = $result->fetch_object()) {
                    echo "<a href='produkt.php?id={$row->produkt_id}' class='produkt'>
                            <img height='250px' width='200px' src='./Obrazy/{$row->obraz}'>
                            <span>{$row->nazwa}</span>
                        </a>";
                }
            }
            if($_GET['W']=="I")
            {
                $query="SELECT * FROM produkt WHERE wydawca_id='4'";
                $result = $connect->query($query);
                while ($row = $result->fetch_object()) {
                    echo "<a href='produkt.php?id={$row->produkt_id}' class='produkt'>
                            <img height='250px' width='200px' src='./Obrazy/{$row->obraz}'>
                            <span>{$row->nazwa}</span>
                        </a>";
                }
            }
            }
            if(ISSET($_GET['K']))
            {
                $Wkat=$_GET['K'];
                $query="SELECT * FROM kategoria_produkty WHERE kategoria_id='$Wkat'";
                $result = $connect->query($query);
                while ($row = $result->fetch_object()) {
                    $prod=$row->produkt_id;
                    $query1="SELECT * FROM produkt WHERE produkt_id='$prod'";
                    $result1 = $connect->query($query1);
                    while ($row1 = $result1->fetch_object()) 
                    {
                        echo "<a href='produkt.php?id={$row1->produkt_id}' class='produkt'>
                        <img height='250px' width='200px' src='./Obrazy/{$row1->obraz}'>
                        <span>{$row1->nazwa}</span>
                        </a>";
                    }
                }

            }

            if(ISSET($_GET['S']))
            {
                $Wszuk=$_GET['S'];
                $query="SELECT * FROM produkt WHERE nazwa LIKE '%$Wszuk%' OR autor LIKE '%$Wszuk%' ";
                $result = $connect->query($query);
                while ($row = $result->fetch_object())
                 {
                        echo "<a href='produkt.php?id={$row->produkt_id}' class='produkt'>
                        <img height='250px' width='200px' src='./Obrazy/{$row->obraz}'>
                        <span>{$row->nazwa}</span>
                        </a>";
                }
            }
            
         ?>   
    </div>

    <?php
    /*function nenuCheck($a)
    {
        echo "test";
    }

    $query="SELECT * FROM produkt";
    $connect->query($query);*/
        
    ?>
</body>
</html>
