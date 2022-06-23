<?php 
if($_SERVER['REQUEST_METHOD']=='POST' && isset($_POST['fuser'])){
    // passar p variaveis locais os dados do form de login
    $user=$_POST['fuser'];
    $pass=$_POST['fpass'];
    $erro = false;

    //pedir à BD a info do user preenchido
    $sql="SELECT * FROM users WHERE nome_u='$user'";
    $resultado=mysqli_query($conn, $sql);

    /* caso a BD tenha retornado algum registo... ou seja SE o utilizador foi reconhecido  */
    if(mysqli_num_rows($resultado)>0){
        $linha=mysqli_fetch_array($resultado);
        // guardar como var local a info retornada da BD: a password encriptada e o nivel de acesso
        $passBd=$linha['pass_u'];
        $nivel =$linha['nivel_u'];
        
        // Verificar se a pass preenchida corresponde à pass armazenada na BD
        if(password_verify($pass,$passBd)){
            $_SESSION['user']=$user;
            $_SESSION['nivel']=$nivel;
        }else{
            $msgLog= "<p class='logP'>A password está incorreta</p>";
        }    
    }else{
        $msgLog= "<p class='logP'>O utilizador $user não foi encontrado</p>";
    }
}

if(!isset($msgLog)){
    $msgLog="";
}


function AlbmGenre($idal){
    include("includes/db/db_conn.php");
    $ida = $idal;
    $sqlUp2 = "SELECT id_al, generos.id_g, generos.nome_g FROM album 
                LEFT JOIN album_has_generos ON album_has_generos.album_id_al = album.id_al 
                LEFT JOIN generos ON generos.id_g = album_has_generos.generos_id_g
                WHERE id_al = '$ida'";
    $result2 = mysqli_query($conn, $sqlUp2);
    
    while($rowArt = $result2 -> fetch_array()){
        if($rowArt["id_g"] > 1 && $rowArt["id_al"] == $ida){
            echo " ".$rowArt["nome_g"];
        }else{
            echo $rowArt["nome_g"];
        }
    }
}

function artistList($idmu){
    include("includes/db/db_conn.php");
    $idm = $idmu;
    $sqlUp = "SELECT id_m, artista.id_a, artista.nome_a FROM musica 
                LEFT JOIN musica_has_artista ON musica_id_m = musica.id_m 
                LEFT JOIN artista ON artista.id_a = musica_has_artista.artista_id_a
                WHERE id_m = '$idm'";
    $result = mysqli_query($conn, $sqlUp);

    while($rowArt = $result -> fetch_array()){
        if($rowArt["id_a"] > 1 && $rowArt["id_m"] == $idm){
            echo ", ".$rowArt["nome_a"];
        }else{
            echo $rowArt["nome_a"];
        }
    } 
}


?>