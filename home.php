<?php 
require_once("includes/db/db_conn.php");
include("includes/webpage/funcs.php");

// sql shenenigans
$sql = "SELECT * FROM album ORDER BY nome_al ASC";
// $sql = "SELECT titulo_m, nome_al, ano_al FROM musica RIGHT JOIN album ON musica.album_id_al = album.id_al ORDER BY titulo_m ASC";
$result = $conn -> query($sql);

// limpa characteres especiais
function clean($string) {
    return preg_replace('/[^A-Za-z0-9\-]/', '', $string);
}
// ISTO É PARA LIMPAR O NOME DO ALBUM QUANDO VEM DA BASE DE DADOS
// PARA SER COMPARADO COM O NOME DO FICHEIRO QUE CONTEM A ARTE DO ALBUM

?>
<!DOCTYPE html>
<html lang="en">
<body>
    <!-- CONTENT -->
    <div id="content">
        
        <?php include("includes/webpage/navTab.php") ?> 
        <h1 class="pageTitle">HOME</h1>
        <div class="nav-pills" aria-orientation="vertical">
            <a data-toggle="pill" href="#v-pills-album">Menu 3</a>
        </div>
        
        <div class="musicDisplay">
            <?php 
                if($result -> num_rows > 0){
                    while($row = $result -> fetch_assoc()){                    
                        $albm = $row["nome_al"];
                        $nAlbm = clean($albm);

                        echo '<a class="boxLink" href="album.php?ida='.$row["id_al"].'">';
                        echo '<div class="box">';
                        if(file_exists('media/'.$nAlbm.'.jpg')){
                            echo '<img class="songImg" src="media/'.$nAlbm.'.jpg" alt="default album cover">';
                        }
                        else{
                            echo '<img class="songImg" src="media/default-album-art.jpg" alt="default album cover">';
                        }
                        echo    '<div class="songInfo">';
                        echo        '<p class="songTitle" title="'.$row["nome_al"].'">'.$row["nome_al"].'</p>';
                        echo    '</div>';
                        echo '</div>';
                        echo '</a>';
                    }
                }
                else{
                    echo "<a href='https://open.spotify.com/playlist/0O8Oc3snLMOcGjDdi9yKY4?si=9d2c537ba8964904' class='easter'>Nada para mostrar</a>";
                }
            ?>
        </div>
    </div>
</body>
</html>