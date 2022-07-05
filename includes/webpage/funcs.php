<?php 

class Bd
{
    protected $conexao;
    protected $opcoes = [
        PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
        PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
        PDO::ATTR_EMULATE_PREPARES => false
    ];

    public function __construct(){
        if(file_exists('../htconfigs/config_modsify.php')){
            $configs='../htconfigs/config_modsify.php';
        }elseif(file_exists('../../htconfigs/config_modsify.php')){
            $configs='../../htconfigs/config_modsify.php';
        }elseif(file_exists('../../../htconfigs/config_modsify.php')){
            $configs='../../../htconfigs/config_modsify.php';
        }elseif(file_exists('../../../../htconfigs/config_modsify.php')){
            $configs='../../../../htconfigs/config_modsify.php';
        }else{
            $configs='../../../../../htconfigs/config_modsify.php';
        }

        require($configs); // <- FUCK YOU YOU FUCKING LINE PIECE OF SHIT I SWEAR I'LL DESTROY YOU FROM THE INSIDE!!
        $dsn = "mysql:host=$host;dbname=$db;charset=utf8mb4";
        $opcoes = $this->opcoes;  
        try{
            $con = new PDO($dsn, $user, $pass, $opcoes);
            $this->conexao = $con;
        }catch(PDOException $e ){
            die("Deu erro: ".$e->getMessage());
        }
    }
    
    public function getPDO(){
        return $this->conexao;
    }
}


class Album{
    private $conexao;
    public function __construct(){
        $pdo = new Bd;
        $con = $pdo->getPDO();
        $this->conexao = $con;
        unset($pdo);
    }

    public function fechaConn(){
        unset($this->conexao_al);
    }

    public function listarAlbum(){
        // sql shenenigans
        $sql = "SELECT * FROM album ORDER BY nome_al ASC";
        $conn = $this->conexao;
        // $sql = "SELECT titulo_m, nome_al, ano_al FROM musica RIGHT JOIN album ON musica.album_id_al = album.id_al ORDER BY titulo_m ASC";
        $result = $conn -> query($sql);
        $dados = $result->fetchAll();
        return $dados;
    }

    /*public function listarAlbumInfo(){
        $ida = $_GET['ida'];

        $sql = "SELECT id_al, nome_al, ano_al, nome_a, artista_id_a, image_al FROM album
                LEFT JOIN artista ON artista.id_a = artista_id_a
                WHERE id_al = ?";
        
        $res = $this->conexao->prepare($sql);
        $res->execute([$ida]);
        $dados = $res->fetchAll();
        return $dados;
    }*/

    public function mostrarAlbuns($res){
        foreach ($res as $row) {
            $id = $row["id_al"];
            $titulo = $row["nome_al"];
            $ano = $row["ano_al"];
            $img = $row["image_al"];

            echo '<a class="boxLink" href="album/album.php?ida='.$id.'">';
            echo '<div class="box">';
            if(file_exists('media/'.$img.'.jpg')){
                echo '<img class="songImg" src="media/'.$img.'.jpg" alt="default album cover">';
            }
            else{
                echo '<img class="songImg" src="media/default-album-art.jpg" alt="default album cover">';
            }
            echo    '<div class="songInfo">';
            echo        '<p class="songTitle" title="'.$titulo.'">'.$titulo.'</p>';
            echo    '</div>';
            echo '</div>';
            echo '</a>';
        }
    }

    public function mostrarInfo(){
        $ida = $_GET['ida'];

        $sql = "SELECT id_al, nome_al, ano_al, nome_a, artista_id_a, image_al FROM album
                LEFT JOIN artista ON artista.id_a = artista_id_a
                WHERE id_al = ?";
        
        $res = $this->conexao->prepare($sql);
        $res->execute([$ida]);
        $dados = $res->fetchAll();
        
        foreach ($dados as $row) {
            $id = $row["id_al"];
            $titulo = $row["nome_al"];
            $ano = $row["ano_al"];
            $nome_a = $row["nome_a"];
            $img = $row["image_al"];

            echo '<div class="album_banner">';
            if(file_exists('media/'.$img.'.jpg')){
                echo '<img class="songImg" src="media/'.$img.'.jpg" alt="default album cover">';
            }
            else{
                echo '<img class="songImg" src="media/default-album-art.jpg" alt="default album cover">';
            }
            echo    '<div class="albumInfo">';
            echo        '<p class="albumTitle">'.$titulo.'</p>';
            echo        '<p class="albumAno">'.$nome_a.' • '.$ano.' • './*$numRows.*/' MUSICAS • ';
                            // AlbmGenre($row["id_al"]);
            echo        '</p>';
            echo    '</div>';
            echo '</div>';
            echo '<br>';
        }
    }

    public function addAlbum()
    {
        $addArray=[
            'nome_al'       => $_POST['Mtitulo'],
            'ano_al'        => $_POST['Aano']
            ];

        $sql = "INSERT INTO album (nome_al, ano_al) VALUES (:nome_al, :ano_al)";
        $conn = $this->conexao;
        $result = $conn->prepare($sql);
        $res = $result->execute($addArray);

        /* verificar o sucesso na inserçao dos dados na BD*/
        if($res === TRUE){
            header("location:index.php?alerta=1");
        }else{
            header("location:index.php?alerta=0");
        }
    }
}

class Songs{
    private $conexao;
    public function __construct(){
        $pdo = new Bd;
        $con = $pdo->getPDO();
        $this->conexao = $con;
        unset($pdo);
    }

    public function fechaConn(){
        unset($this->conexao);
    }

    public function listarSongs(){
        $ida = $_GET['ida'];

        $sql = "SELECT titulo_m, id_al, id_m FROM musica 
                LEFT JOIN album ON album.id_al = musica.album_id_al 
                WHERE id_al = ?";

        $res = $this->conexao->prepare($sql);
        $res->execute([$ida]);
        $dados = $res->fetchAll();
        return $dados;
    }

    public function mostrarSongs($res){
        foreach ($res as $row) {
            $id = $row["id_m"];
            $titulo = $row["titulo_m"];
            
            echo '<h1 style="color: white;">MUSICAS</h1>';
            echo '<div class="musicShow">';                 
                echo    '<div class="songInfo">';
                echo        '<p class="songTitle">'.$titulo.'</p>';
                echo        '<p class="songYear">';
                                // artistList($row["id_m"]);
                echo        '</p>';
                echo    '</div>';
            echo '</div>';
        }
    }
}













// if($_SERVER['REQUEST_METHOD']=='POST' && isset($_POST['fuser'])){
//     // passar p variaveis locais os dados do form de login
//     $user=$_POST['fuser'];
//     $pass=$_POST['fpass'];
//     $erro = false;

//     //pedir à BD a info do user preenchido
//     $sql="SELECT * FROM users WHERE nome_u='$user'";
//     $resultado=mysqli_query($conn, $sql);

//     /* caso a BD tenha retornado algum registo... ou seja SE o utilizador foi reconhecido  */
//     if(mysqli_num_rows($resultado)>0){
    //         $linha=mysqli_fetch_array($resultado);
    //         // guardar como var local a info retornada da BD: a password encriptada e o nivel de acesso
    //         $passBd=$linha['pass_u'];
    //         $nivel =$linha['nivel_u'];
        
//         // Verificar se a pass preenchida corresponde à pass armazenada na BD
//         if(password_verify($pass,$passBd)){
    //             $_SESSION['user']=$user;
    //             $_SESSION['nivel']=$nivel;
    //         }else{
        //             $msgLog= "<p class='logP'>A password está incorreta</p>";
        //         }    
        //     }else{
//         $msgLog= "<p class='logP'>O utilizador $user não foi encontrado</p>";
//     }
// }

// if(!isset($msgLog)){
    //     $msgLog="";
    // }

    // function AlbmGenre($idal){
        //     include("includes/db/db_conn.php");
//     $ida = $idal;
//     $sqlUp2 = "SELECT id_al, generos.id_g, generos.nome_g FROM album 
//                 LEFT JOIN album_has_generos ON album_has_generos.album_id_al = album.id_al 
//                 LEFT JOIN generos ON generos.id_g = album_has_generos.generos_id_g
//                 WHERE id_al = '$ida'";
//     $result2 = mysqli_query($conn, $sqlUp2);
    
//     while($rowArt = $result2 -> fetch_array()){
//         if($rowArt["id_g"] > 1 && $rowArt["id_al"] == $ida){
//             echo " ".$rowArt["nome_g"];
//         }else{
//             echo $rowArt["nome_g"];
//         }
//     }
// }

// function artistList($idmu){
    //     include("includes/db/db_conn.php");
    //     $idm = $idmu;
    //     $sqlUp = "SELECT id_m, artista.id_a, artista.nome_a FROM musica 
    //                 LEFT JOIN musica_has_artista ON musica_id_m = musica.id_m 
    //                 LEFT JOIN artista ON artista.id_a = musica_has_artista.artista_id_a
    //                 WHERE id_m = '$idm'";
    //     $result = mysqli_query($conn, $sqlUp);
    
    //     while($rowArt = $result -> fetch_array()){
        //         if($rowArt["id_a"] > 1 && $rowArt["id_m"] == $idm){
            //             echo ", ".$rowArt["nome_a"];
//         }else{
//             echo $rowArt["nome_a"];
//         }
//     } 
// }

?>