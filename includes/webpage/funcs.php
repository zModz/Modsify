<?php 

class Bd{
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

#User
Class User{
    private $conexao;

    public function __construct(){
        $pdo=new Bd;
        $con=$pdo->getPDO();
        $this->conexao=$con;
        unset($pdo);
    }

    public function Login(){
        $conexao=$this->conexao;
        $error = 0;

        // passar p variaveis locais os dados do form de login
        $user=$_POST['fuser'];
        $pass=$_POST['fpass'];

        //pedir à BD a info do user preenchido
        $sql="SELECT * FROM users WHERE nome_u=?";
        $stmt = $conexao->prepare($sql);
        $resultado = $stmt->execute([$user]);

        /* caso a BD tenha retornado algum registo... ou seja SE o utilizador foi reconhecido  */
        if($resultado != FALSE){
            $linha = $stmt->fetch();
            // guardar como var local a info retornada da BD: a password encriptada e o nivel de acesso
            $passBd = $linha['pass_u'];
            $nivel = $linha['nivel_u'];
            
            // Verificar se a pass preenchida corresponde à pass armazenada na BD
            if(password_verify($pass, $passBd)){
                $_SESSION['user'] = $user;
                $_SESSION['nivel'] = $nivel;
            }else{
                // return "<p class='logP'>A password está incorreta</p>";
                $error = 1;
            }    
        }
        else{
            // return "<p class='logP'>O utilizador $user não foi encontrado</p>";
            $error = 2;
        }

        return $error;
    }

    public function user_verify($username)
    {
        $sql = "SELECT *FROM users WHERE nome_u=?";
        $conexao=$this->conexao;
        $resultado = $conexao->prepare($sql);
        $resultado->execute([$username]);
        $dados=$resultado->fetchAll();

        if(!empty($dados)){
            return FALSE;
        }else{
            return TRUE;
        }
    }

    public function adduser($username){
        $conexao=$this->conexao;
        if($this->user_verify($username) == FALSE){
            return; // Return to index with error message.
        }

        $password = password_hash($_POST["fpass"], PASSWORD_DEFAULT);
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

#Album
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

    public function listarAlbums(){
        // sql shenenigans
        $sql = "SELECT *, nome_a FROM album
                LEFT JOIN artista ON artista.id_a = artista_id_a
                ORDER BY nome_al DESC";

        $conn = $this->conexao;
        $result = $conn -> query($sql);
        $dados = $result->fetchAll();
        return $dados;
    }

    public function listarAlbumInfo(){
        $ida = $_GET['ida'];

        $sql = "SELECT *, id_a, nome_a FROM album
                LEFT JOIN artista ON artista.id_a = artista_id_a
                WHERE id_al = ?";
        
        $res = $this->conexao->prepare($sql);
        $res->execute([$ida]);
        $dados = $res->fetchAll();
        return $dados;
    }

    public function listarAlbumArtista(){
        $ida = $_GET['ida'];

        $sql = "SELECT *, id_a, nome_a FROM album
                LEFT JOIN artista ON artista.id_a = artista_id_a
                WHERE id_a = ?";
        
        $res = $this->conexao->prepare($sql);
        $res->execute([$ida]);
        $dados = $res->fetchAll();
        return $dados;
    }

    // Pill Design
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
        echo '<p class="boxLink"></p>';
    }

    protected function listarAlbumGenero($idal)
    {
        $ida = $idal;
        $sqlUp2 = "SELECT id_al, generos.id_g, generos.nome_g FROM album 
                    LEFT JOIN album_has_generos ON album_has_generos.album_id_al = album.id_al 
                    LEFT JOIN generos ON generos.id_g = album_has_generos.generos_id_g
                    WHERE id_al = ?";

        $res = $this->conexao->prepare($sqlUp2);
        $res->execute([$ida]);

        while($rowArt = $res->fetch()){
            if($rowArt["id_g"] > 1 && $rowArt["id_al"] == $ida){
                echo " ".$rowArt["nome_g"];
            }else{
                echo $rowArt["nome_g"];
            }
        }
    }

    // Banner View
    public function mostrarInfo($res){
        $a = new Songs;
        foreach ($res as $row) {
            $id = $row["id_a"];
            $ida = $row['id_al'];
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
            echo        '<p class="albumAno"><a class="artistLink" href="artista.php?ida='.$id.'">'.$nome_a.'</a> • '.$ano.' • '.count($a->listarSongsAlbum()).' MUSICAS • ';
                            $this->listarAlbumGenero($ida);
            echo        '</p>';
            echo    '</div>';
            echo '</div>';
            echo '<br>';
        }
    }

    // Card Design
    public function mostrarAlbumCard($res){
        foreach ($res as $row) {
            $id = $row["id_al"];
            $titulo = $row["nome_al"];
            $ano = $row["ano_al"];
            $img = $row["image_al"];
            
            // file_exists('media/'.$img.'')
            echo '<a class="albumBoxLink" href="album.php?ida='.$id.'">';
            echo '<div class="card" style="width: 18rem;">';
            if($img != NULL){
                echo '<img id="songImg" class="card-img-top" src="media/'.$img.'" alt="'.$titulo.'">';
            }
            else{
                echo '<img class="card-img-top" src="media/default-album-art.jpg" alt="default album cover">';
            }
            echo '    <div class="card-body">';
            echo '        <h5 class="card-title">'.$titulo.'</h5>';
            echo '        <p class="card-text">'.$ano.'</p>';
            echo '    </div>';
            echo '</div>';
            echo '</a>';
        }
    }

    public function addAlbum(){
        $nomeAl = $_POST['Mtitulo'];

        $addArray=[
            'nome_al'       => $_POST['Mtitulo'],
            'ano_al'        => $_POST['Aano'],
            'id_a'          => $_POST['artistDrop'],
            'image_al'      => uploadPhoto("media/", $nomeAl, "cover")
        ];

        $sql = "INSERT INTO album (nome_al, ano_al, artista_id_a, image_al) VALUES (:nome_al, :ano_al, :id_a, :image_al)";
        $conn = $this->conexao;
        $result = $conn->prepare($sql);

        $sql2 = "SELECT * FROM album";
        $result2 = $conn->query($sql2);
        $albumArr = $result2->fetchAll();
        $albums = count($albumArr) + 2;
        $addArray2=[
            'albums'     => $albums,
            'id_g'      => $_POST['generoDrop'],
        ];
        
        $sqlArtist = "INSERT INTO album_has_generos (album_id_al, generos_id_g) VALUES (:albums, :id_g)";
        $result3 = $conn->prepare($sqlArtist);

        $res = $result->execute($addArray);
        $res2 = $result3->execute($addArray2);

        /* verificar o sucesso na inserçao dos dados na BD*/
        if($res === TRUE && $res2 === TRUE){
            header("location:index.php?alerta=1");
        }else{
            header("location:index.php?alerta=0");
        }
    }

    public function formEditar(){
        $ar = new Artista;
        $resAr = $ar->listarArtista();
        $g = new Generos;
        $resG = $g->listarGeneros();
        $conexao = $this->conexao;

        $ida = $_GET['ida'];  // colocar o id do URL numa variavel local
        $sql = "SELECT * FROM album 
                LEFT JOIN artista ON artista.id_a = artista_id_a
                WHERE id_al=?";
        /* enviar a instruçao para a BD*/
        $resultado = $conexao->prepare($sql);
        $resultado->execute([$ida]);
        $registo = $resultado->fetch();
        
        // passar os elementos do array p variaveis
        $arrayDados=[
            "nome"          => $registo['nome_al'],
            "ano"           => $registo['ano_al'],
        ];

        echo '<form action="" method="post" enctype="multipart/form-data">';
        echo  '<table id="formTab">';
        echo  '<tr>';
        echo      '<td>Artista do album: </td>';
        echo      '<td>';
        echo        '<select name="artistDrop" id="dropArtist">';
                        foreach($resAr as $row){
                            echo        '<option value="'.$row["id_a"].'">'.$row["nome_a"].'</option>';
                        }
        echo        '</select>';
        echo      '</td>';
        echo    '</tr>';
        echo    '<tr>';
        echo        '<td>Titulo do album: </td>';
        echo        '<td><input type="text" name="Mtitulo" value="'.$arrayDados["nome"].'" required> </td>';
        echo    '</tr>';
        echo    '<tr>';
        echo        '<td>Ano de lançamento: </td>';
        echo        '<td><input type="text" name="Aano" value=" '.$arrayDados["ano"].' " required> </td>';
        echo    '</tr>';
        echo    '<tr>';
        echo        '<td>Capa do album: </td>';
        echo        '<td><input type="file" name="cover"> </td>';
        echo    '</tr>';
        echo '  <tr>';
        echo '        <td>Genero: </td>';
        echo '        <td>';
        echo '          <select name="generoDrop" id="dropGenero" required>';
                            foreach($resG as $row){
                            echo '<option value="'.$row["id_g"].'">'.$row["nome_g"].'</option>';
                            }
        echo '          </select>';
        echo '        </td>';
        echo '      </tr>';
        echo    '<tr>';
        echo        '<td> </td>';
        echo        '<td><input type="submit" value="Atualizar"> </td>';
        echo    '</tr>';
        echo  '</table>';
        echo '</form>';
    }

    public function editarAlbum(){
        $conexao = $this->conexao;
        $ida = $_GET['ida'];
        $nomeAl = $_POST["Mtitulo"];

        $arrDados=[
            "titulo"    => $_POST["Mtitulo"], 
            "artista"   => $_POST["artistDrop"], 
            'image_al'  => uploadPhoto("media/", $nomeAl, "cover"),
            "ano"       => $_POST["Aano"],
            "id_al"     => $_GET['ida']
        ];
        

        $sql = "UPDATE album SET nome_al = :titulo, ano_al = :ano, artista_id_a = :artista, image_al = :image_al WHERE id_al = :id_al";
        $stmt = $conexao->prepare($sql);

        $addArray2=[
            'id_g'  => $_POST['generoDrop'],
            "id_al"       => $_GET['ida']
        ];
        
        $sqlArtist = "UPDATE album_has_generos SET generos_id_g = :id_g WHERE album_id_al = :id_al";
        $result3 = $conexao->prepare($sqlArtist);

        $res = $stmt->execute($arrDados);
        $res2 = $result3->execute($addArray2);

        if($res === TRUE && $res2 === TRUE){
            $fdb = 1;
            header('location: album.php?ida='.$ida.'&alerta='.$fdb);
        }
        else {
            $fdb = 0;
            header("location: erro.php?alerta=".$fdb);
        }
    }

    public function removerAlbum()
    {
        $ida = $_GET['ida'];
        $sqlrm = "DELETE FROM album WHERE id_al = ?";
        $res = $this->conexao->prepare($sqlrm);
        $res->execute([$ida]);
        
        if($res === true){
            $fdb = 1;
            header("location: index.php?alerta=".$fdb);
        }
        else{
            $fdb = 0;
            header("location: erro.php?alerta=".$fdb);  
        }
    }
}

function uploadPhoto($dir, $name, $whatIs){
    // Verificar se o formulário foi submetido
    if($_SERVER['REQUEST_METHOD']=='POST'){
        $name = str_replace(" ", "", $name);
        $file = $_FILES[$whatIs]['tmp_name'];
        
        $fileType = strtolower(pathinfo($_FILES[$whatIs]['name'], PATHINFO_EXTENSION));
        if($whatIs != NULL){
            $novonome = $name. "." . $fileType;
            $path = $dir . $novonome;
        }

        move_uploaded_file($file, $path);
        return $novonome;
    }

    return "template";
}

#Songs
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

    protected function listarSongsArtists($idmu)
    {
        $idm = $idmu;
        $sqlUp = "SELECT id_m, artista.id_a, artista.nome_a FROM musica 
                  LEFT JOIN musica_has_artista ON musica_id_m = musica.id_m 
                  LEFT JOIN artista ON artista.id_a = musica_has_artista.artista_id_a
                  WHERE id_m = ?";

        $res = $this->conexao->prepare($sqlUp);
        $res->execute([$idm]);

        while($rowArt = $res->fetch()){
            if($rowArt["id_a"] > 1 && $rowArt["id_m"] == $idm){
                echo ", ".$rowArt["nome_a"];
            }else{
                echo $rowArt["nome_a"];
            }
        } 
    }

    public function listarSongsAlbum(){
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
        if($res != NULL){
            foreach ($res as $row) {
                $id = $row["id_m"];
                $titulo = $row["titulo_m"];
                
                echo '<div class="musicShow">';                 
                echo    '<div class="songInfo">';
                echo        '<p class="songTitle">'.$titulo.'</p>';
                echo        '<p class="songYear">';
                    $this->listarSongsArtists($id);
                echo        '</p>';
                echo    '</div>';
                echo '</div>';
            }
        }
        else{
            echo '<p class="error">NO RESULTS FOUND!</p>';
        }
        
    }

    public function addSong(){
        $al = $_POST['albumDrop'];
        
        $addArray=[
            'nome_s'      => $_POST['Stitulo'],
            'album_s'     => $_POST['albumDrop'],
        ];

        $sqlSong = "INSERT INTO musica (titulo_m, album_id_al) VALUES (:nome_s, :album_s)";
        $conn = $this->conexao;
        $result = $conn->prepare($sqlSong);
        
        $sql2 = "SELECT * FROM musica";
        $result2 = $conn->query($sql2);
        $songArr = $result2->fetchAll();
        $songs = count($songArr) + 2;
        $addArray2=[
            'songs'     => $songs,
            'artist_s'  => $_POST['artistDrop']  
        ];
        
        $sqlArtist = "INSERT INTO musica_has_artista (musica_id_m, artista_id_a) VALUES (:songs, :artist_s)";
        $result3 = $conn->prepare($sqlArtist);
        
        $res = $result->execute($addArray);
        $res2 = $result3->execute($addArray2);

        /* verificar o sucesso na inserçao dos dados na BD*/
        if($res === TRUE && $res2 === TRUE){
            header("location:album.php?ida='.$al.'&alerta=1");
        }else{
            header("location:erro.php?alerta=0");
        }
    }

    public function formEditar(){
        $conexao = $this->conexao;

        $al = new Album;
        $resAl = $al->listarAlbums();
        $ar = new Artista;
        $resAr = $ar->listarArtista();

        $idm = $_GET['idm'];  // colocar o id do URL numa variavel local
        $sql="SELECT * FROM musica WHERE id_m = ?";
        /* enviar a instruçao para a BD*/
        $resultado = $conexao->prepare($sql);
        $resultado->execute([$idm]);
        $registo = $resultado->fetch();
        
        // passar os elementos do array p variaveis
        $arrayDados=[
            "nome"      => $registo['titulo_m'],
        ];
        
        echo '<form action="" method="post">';
        echo '  <table id="formTab">';
        echo '    <tr>';
        echo '      <td>Titulo da Musica: </td>';
        echo '      <td><input type="text" name="Stitulo" value="'.$arrayDados['nome'].'" required> </td>';
        echo '    </tr>';
        echo '    <tr>';
        echo '      <td>Album: </td>';
        echo '      <td>';
        echo '        <select name="albumDrop" id="dropAlbum">';
                        foreach($resAl as $row){
                          echo '<option value="'.$row["id_al"].'">'.$row["nome_al"].'</option>';
                        }
        echo '        </select>';
        echo '      </td>';
        echo '    </tr>';
        echo '    <tr>';
        echo '      <td>Artista(s): </td>';
        echo '      <td>';
        echo '        <select name="artistDrop" id="dropArtist">';
                        foreach($resAr as $row){
                          echo '<option value="'.$row["id_a"].'">'.$row["nome_a"].'</option>';
                        }
        echo '        </select> ';
        echo '      </td>';
        echo '    </tr>';
        echo '    <tr>';
        echo '      <td> </td>';
        echo '      <td><input type="submit" value="Adicionar"> </td>';
        echo '    </tr>';
        echo '  </table>';
        echo '</form>';
    }

    public function editarSong(){
        $conexao = $this->conexao;
        $ida = $_POST['albumDrop'];

        $arrDados=[
            'nome_s'      => $_POST['Stitulo'],
            'album_s'     => $_POST['albumDrop'],
            "id_m"       => $_GET['idm']
        ];
        
        $sql = "UPDATE musica SET titulo_m = :nome_s, album_id_al = :album_s WHERE id_m = :id_m";
        $stmt = $conexao->prepare($sql);
        
        $addArray2=[
            'artist_s'  => $_POST['artistDrop'],
            "id_m"       => $_GET['idm']
        ];
        
        $sqlArtist = "UPDATE musica_has_artista SET artista_id_a = :artist_s WHERE musica_id_m = :id_m";
        $result3 = $conexao->prepare($sqlArtist);
        
        $res = $stmt->execute($arrDados);
        $res2 = $result3->execute($addArray2);

        if($res === TRUE && $res2 === TRUE){
            header('location: album.php?ida='.$ida.'&alerta=1');
        }
        else {
            header("location: erro.php?alerta=0");
        }
    }

    public function removerSong()
    {
        $idm = $_GET['idm'];
        $sqlrm = "DELETE FROM musica_has_artista WHERE musica_id_m = ?";
        $res = $this->conexao->prepare($sqlrm);
        
        $sqlrm2 = "DELETE FROM musica WHERE id_m = ?";
        $res2 = $this->conexao->prepare($sqlrm2);
        
        $res->execute([$idm]);
        $res2->execute([$idm]);
        
        if($res === true){
            header('location: album.php?ida='.$ida.'&alerta=1');
        }
        else{
            header("location: erro.php?alerta=0");  
        }
    }
}

#Artista
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
        $sql = "SELECT * FROM artista"; #WHERE image_a REGEXP '^[a-zA-Z]'

        $conn = $this->conexao;
        $result = $conn -> query($sql);
        $dados = $result->fetchAll();
        return $dados;
    }

    public function listarArtistaInfo(){
        $ida = $_GET['ida'];

        $sql = "SELECT * FROM artista
                WHERE id_a = ?";
        
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
            echo '<a class="artistBoxLink" href="artista.php?ida='.$id.'">';
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
            if($artistImg != NULL){
                echo '<img class="songImg" src="media/artists/'.$artistImg.'" alt="'.$artist.'">';
            }
            else{
                echo '<img class="songImg" src="media/default-album-art.jpg" alt="default album cover">';
            }
            echo    '<div class="albumInfo">';
            echo        '<p class="albumTitle">'.$artist.'</p>';
            echo    '</div>';
            echo '</div>';
            echo '<br>';
        }
    }

    public function addArtista(){
        $nomeAl = $_POST['arNome'];

        $addArray=[
            'nome_a'       => $_POST['arNome'],
            'image_a'      => uploadPhoto("media/artists/", $nomeAl, "img")
        ];

        $sql = "INSERT INTO artista (nome_a, image_a) VALUES (:nome_a, :image_a)";
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

        $ida= $_GET['ida'];  // colocar o id do URL numa variavel local
        $sql="SELECT * FROM artista WHERE id_a = ?";
        /* enviar a instruçao para a BD*/
        $resultado = $conexao->prepare($sql);
        $resultado->execute([$ida]);
        $registo = $resultado->fetch();
        
        // passar os elementos do array p variaveis
        $arrayDados=[
            "nome"      => $registo['nome_a'],
        ];
        
        echo '<form action="" method="post" enctype="multipart/form-data">';
        echo '  <table id="formTab">';
        echo '    <tr>';
        echo '      <td>Nome do Artista: </td>';
        echo '      <td><input type="text" name="arNome" value="'.$arrayDados["nome"].'" required> </td>';
        echo '    </tr>';
        echo '    <tr>';
        echo '      <td>Imagem do artista: </td>';
        echo '      <td><input type="file" name="img"> </td>';
        echo '    </tr>';
        echo '    <tr>';
        echo '      <td> </td>';
        echo '      <td><input type="submit" value="Adicionar"> </td>';
        echo '    </tr>';
        echo '  </table>';
        echo '</form>';
    }

    public function editarArtista(){
        $conexao = $this->conexao;
        $ida = $_GET['ida'];
        $nomeAr = $_POST['arNome'];

        $arrDados=[
            'nome'       => $_POST['arNome'],
            'imageAr'    => uploadPhoto("media/artists/", $nomeAr, "img"),
            "id_a"       => $_GET['ida']
        ];
        

        $sql = "UPDATE artista SET nome_a = :nome, image_a = :imageAr WHERE id_a = :id_a";
        $stmt = $conexao->prepare($sql);
        $res = $stmt->execute($arrDados);

        if($res === TRUE){
            $fdb = 1;
            header('location: artista.php?ida='.$ida.'&alerta='.$fdb);
        }
        else {
            $fdb = 0;
            header("location: erro.php?alerta=".$fdb);
        }
    }

    public function removerArtista()
    {
        $ida = $_GET['ida'];
        $sqlrm = "DELETE FROM artista WHERE id_a = ?";
        $res = $this->conexao->prepare($sqlrm);
        $res->execute([$ida]);
        
        if($res === true){
            $fdb = 1;
            header("location: index.php?alerta=".$fdb);
        }
        else{
            $fdb = 0;
            header("location: erro.php?alerta=".$fdb);  
        }
    }
}

#Songs
class Generos{
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

    public function listarGeneros(){
        $sql = "SELECT * FROM generos"; 

        $res = $this->conexao->query($sql);
        $dados = $res->fetchAll();
        return $dados;
    }

    public function mostrarGeneros($res){
        if($res != NULL){
            foreach ($res as $row) {
                $id = $row["id_g"];
                $titulo = $row["nome_g"];
                
                echo '<div class="musicShow">';                 
                echo    '<div class="songInfo">';
                echo        '<p class="songTitle">'.$titulo.'</p>';
                echo    '</div>';
                echo '</div>';
            }
        }
        else{
            echo '<p class="error">NO RESULTS FOUND!</p>';
        }
        
    }

    public function addGeneros(){

        $addArray=[
            'nome_g'      => $_POST['gNome'],
        ];

        $sql = "INSERT INTO generos (nome_g) VALUES (:nome_g)";
        $conn = $this->conexao;
        $result = $conn->prepare($sql);
        $res = $result->execute($addArray);
        
        /* verificar o sucesso na inserçao dos dados na BD*/
        if($res === TRUE){
            header("location:index.php?alerta=1");
        }else{
            header("location:erro.php?alerta=0");
        }
    }

    public function formEditar(){
        $conexao = $this->conexao;

        $idg = $_GET['idg'];  // colocar o id do URL numa variavel local
        $sql="SELECT * FROM generos WHERE id_g = ?";
        /* enviar a instruçao para a BD*/
        $resultado = $conexao->prepare($sql);
        $resultado->execute([$idg]);
        $registo = $resultado->fetch();
        
        // passar os elementos do array p variaveis
        $arrayDados=[
            "nome"      => $registo['nome_g'],
        ];
        
        echo '<form action="" method="post" enctype="multipart/form-data">';
        echo '  <table id="formTab">';
        echo '    <tr>';
        echo '      <td>Nome do Genero: </td>';
        echo '      <td><input type="text" name="gNome" value="'.$arrayDados['nome'].'" required> </td>';
        echo '    </tr>';
        echo '    <tr>';
        echo '      <td> </td>';
        echo '      <td><input type="submit" value="Adicionar"> </td>';
        echo '    </tr>';
        echo '  </table>';
        echo '</form>';
    }

    public function editarGenero(){
        $conexao = $this->conexao;
        $ida = $_POST['albumDrop'];

        $arrDados=[
            'nome_g'    => $_POST['gNome'],
            'id_g'       => $_GET['idg']
        ];
        
        $sql = "UPDATE generos SET nome_g = :nome_g WHERE id_g = :id_g";
        $stmt = $conexao->prepare($sql);
        $res = $stmt->execute($arrDados);
        
        if($res === TRUE){
            header('location: index.php?alerta=1');
        }
        else {
            header("location: erro.php?alerta=0");
        }
    }

    public function removerGenero(){
        $idg = $_GET['idg'];
        
        $sqlrm2 = "DELETE FROM generos WHERE id_g = ?";
        $res2 = $this->conexao->prepare($sqlrm2);
        $res->execute([$idg]);
        
        if($res === true){
            header('location: index.php?alerta=1');
        }
        else{
            header("location: erro.php?alerta=0");  
        }
    }
}

?>