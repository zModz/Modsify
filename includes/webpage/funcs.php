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

Class User{
    private $conexao;

    public function __construct(){
        $pdo=new Bd;
        $con=$pdo->getPDO();
        $this->conexao=$con;
        unset($pdo);
    }

    public function user_verify($username){
        $conexao=$this->conexao;
        
        $sql = "SELECT * FROM users WHERE nome_u = :username";
        $resultado = $conexao->prepare($sql);
        $resultado->execute([$username]);
        $dados = $resultado->fetch();
        print_r($dados);
        
        $pass = $dados["pass_u"];
        $passHash = password_verify($_POST["fpass"], $pass);
        
        if(!empty($dados) || $passHash == false){
            echo "DEU ERRO!";
            echo $passHash;
        }else{
            echo "DEU CERTO!";
            echo $passHash;
        }
    }

    public function adduser($username){
        $password = password_hash($_POST["fpass"], PASSWORD_DEFAULT);

        $conexao=$this->conexao;
        
        $sql = "INSERT INTO users (nome_u, pass_u) VALUES (:username, :password)";
        $stmt = $conexao->prepare($sql);
        $resultado=$stmt->execute([$username, $password]);
        
        if($resultado == TRUE){
            header("location:index.php?alerta=6");
        }else{
            header("location:index.php?alerta=0");
        }
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
        // $sql = "SELECT * FROM album ORDER BY nome_al ASC";
        $sql = "SELECT *, nome_a FROM album
                LEFT JOIN artista ON artista.id_a = artista_id_a";
        $conn = $this->conexao;
        // $sql = "SELECT titulo_m, nome_al, ano_al FROM musica RIGHT JOIN album ON musica.album_id_al = album.id_al ORDER BY titulo_m ASC";
        $result = $conn -> query($sql);
        $dados = $result->fetchAll();
        return $dados;
    }

    public function listarAlbumInfo(){
        $ida = $_GET['ida'];

        $sql = "SELECT *, nome_a FROM album
                LEFT JOIN artista ON artista.id_a = artista_id_a
                WHERE id_al = ?";
        
        $res = $this->conexao->prepare($sql);
        $res->execute([$ida]);
        $dados = $res->fetchAll();
        return $dados;
    }

    public function mostrarAlbuns($res){
        foreach ($res as $row) {
            $id = $row["id_al"];
            $titulo = $row["nome_al"];
            $artist = $row["nome_a"];
            $ano = $row["ano_al"];
            $img = $row["image_al"];

            // file_exists('media/'.$img.'')
            echo '<a class="boxLink" href="album.php?ida='.$id.'">';
            echo '<div class="box">';
            if($img != NULL){
                echo '<img class="songImg" src="media/'.$img.'" alt="'.$titulo.'">';
            }
            else{
                echo '<img class="songImg" src="media/default-album-art.jpg" alt="default album cover">';
            }
            echo    '<div class="albumInfo">';
            echo        '<p class="albumTitle" title="'.$titulo.'">'.$titulo.'</p>';
            echo        '<p class="albumArts">'.$artist.'</p>';
            echo        '<p class="albumAno">'.$ano.'</p>';
            echo    '</div>';
            echo '</div>';
            echo '</a>';
        }
    }

    public function mostrarInfo($res){
        foreach ($res as $row) {
            $id = $row["id_al"];
            $titulo = $row["nome_al"];
            $ano = $row["ano_al"];
            $nome_a = $row["nome_a"];
            $img = $row["image_al"];
            
            // file_exists('media/'.$img.'')
            echo '<div id="banner" class="album_banner">';
            if($img != NULL){
                echo '<img id="songImg" class="songImg" src="media/'.$img.'" alt="'.$titulo.'">';
            }
            else{
                echo '<img class="songImg" src="media/default-album-art.jpg" alt="default album cover">';
            }
            echo    '<div class="albumInfo">';
            echo        '<p class="albumTitle">'.$titulo.'</p>';
            echo        '<p class="albumAno">'.$nome_a.' • '.$ano.' • '.count($row).' MUSICAS • ';
                            // AlbmGenre($row["id_al"]);
            echo        '</p>';
            echo    '</div>';
            echo '</div>';
            echo '<br>';
        }
    }

    public function addAlbum(){
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

    public function formEditar(){
        $conexao = $this->conexao;

        $idc= $_GET['idc'];  // colocar o id do URL numa variavel local
        $sql="SELECT * FROM album WHERE id_al=?";
        /* enviar a instruçao para a BD*/
        $resultado = $conexao->prepare($sql);
        $resultado->execute([$idc]);
        $registo = $resultado->fetchAll();
        
        // passar os elementos do array p variaveis
        $arrayDados=[
            "nome"      => $registo[0]['nome_al'],
            "ano"       => $registo[0]['ano_al'],
        ];
        return $arrayDados;
    }

    public function editarAlbum(){
        $conexao = $this->conexao;

        $arrDados=[
            "titulo" => $_POST["Mtitulo"], 
            "artista" => $_POST["Martist"], 
            "album" => $_POST["Malbum"],
            "ano" => $_POST["Mano"],
            "id_a" => $_GET['ida']
        ];
        

        $sql = "UPDATE album SET nome_al=:titulo,ano_al=:ano WHERE id_al = :id_a";
        $stmt = $conexao->prepare($sql);
        $res = $stmt->execute($arrDados);

        if($res === TRUE){
            $fdb = 1;
            header('location: album.php?ida=:id_a&alerta='.$fdb);
        }
        else {
            $fdb = 0;
            header("location: erro.php?alerta=".$fdb);
        }
    }

    public function removerAlbum()
    {
        # code...
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
            
            echo '<div class="musicShow">';                 
            echo    '<div class="songInfo">';
            echo        '<p class="songTitle">'.$titulo.'</p>';
            echo        '<p class="songYear">NOME';
            echo        '</p>';
            echo    '</div>';
            echo '</div>';
        }
    }
}

class Artista{
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

    public function listarArtista(){
        // sql shenenigans
        // $sql = "SELECT * FROM album ORDER BY nome_al ASC";
        $sql = "SELECT * FROM artista LIMIT 5";

        $conn = $this->conexao;
        // $sql = "SELECT titulo_m, nome_al, ano_al FROM musica RIGHT JOIN album ON musica.album_id_al = album.id_al ORDER BY titulo_m ASC";
        $result = $conn -> query($sql);
        $dados = $result->fetchAll();
        return $dados;
    }

    public function listarArtistaInfo(){
        $ida = $_GET['ida'];

        $sql = "SELECT *, nome_al FROM artista
                LEFT JOIN album ON id_a = album.artista_id_a
                WHERE id_al = ?";
        
        $res = $this->conexao->prepare($sql);
        $res->execute([$ida]);
        $dados = $res->fetchAll();
        return $dados;
    }

    public function mostrarArtista($res){
        foreach ($res as $row) {
            $id = $row["id_a"];
            $artist = $row["nome_a"];
            $artistImg = $row["image_a"];
            
            // file_exists('media/artists/'.$artistImg.'')
            echo '<a class="artistBoxLink" href="#">';
            echo '<div class="card" style="width: 18rem;">';
            if($artistImg != NULL){
                echo '<img id="songImg" class="card-img-top" src="media/artists/'.$artistImg.'" alt="'.$artist.'">';
            }
            else{
                echo '<img class="card-img-top" src="media/default-album-art.jpg" alt="default album cover">';
            }
            echo '    <div class="card-body">';
            echo '        <h5 class="card-title">'.$artist.'</h5>';
            echo '    </div>';
            echo '</div>';
            echo '</a>';
        }
    }

    public function mostrarInfoArtista($res){
        foreach ($res as $row) {
            $id = $row["id_a"];
            $artist = $row["nome_a"];
            $artistImg = $row["image_a"];
            
            // file_exists('media/artists/'.$artistImg.'')
            echo '<div class="album_banner">';
            if($artistImg != ""){
                echo '<img id="songImg" class="card-img-top" src="media/artists/'.$artistImg.'" alt="'.$artist.'">';
            }
            else{
                echo '<img class="card-img-top" src="media/default-album-art.jpg" alt="default album cover">';
            }
            echo    '<div class="albumInfo">';
            echo        '<p class="albumTitle">'.$artist.'</p>';
            echo    '</div>';
            echo '</div>';
            echo '<br>';
        }
    }

    public function addAlbum(){
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

    public function formEditar(){
        $conexao = $this->conexao;

        $idc= $_GET['idc'];  // colocar o id do URL numa variavel local
        $sql="SELECT * FROM album WHERE id_al=?";
        /* enviar a instruçao para a BD*/
        $resultado = $conexao->prepare($sql);
        $resultado->execute([$idc]);
        $registo = $resultado->fetchAll();
        
        // passar os elementos do array p variaveis
        $arrayDados=[
            "nome"      => $registo[0]['nome_al'],
            "ano"       => $registo[0]['ano_al'],
        ];
        return $arrayDados;
    }

    public function editarAlbum(){
        $conexao = $this->conexao;

        $arrDados=[
            "titulo" => $_POST["Mtitulo"], 
            "artista" => $_POST["Martist"], 
            "album" => $_POST["Malbum"],
            "ano" => $_POST["Mano"],
            "id_a" => $_GET['ida']
        ];
        

        $sql = "UPDATE album SET nome_al=:titulo,ano_al=:ano WHERE id_al = :id_a";
        $stmt = $conexao->prepare($sql);
        $res = $stmt->execute($arrDados);

        if($res === TRUE){
            $fdb = 1;
            header('location: album.php?ida=:id_a&alerta='.$fdb);
        }
        else {
            $fdb = 0;
            header("location: erro.php?alerta=".$fdb);
        }
    }

    public function removerAlbum()
    {
        # code...
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