<!DOCTYPE html>
<html lang="en">
    <?php include ("includes/webpage/head.php") ?>
    <body>
        <div class="content-wrapper d-flex align-items-start">
            <div class="nav flex-column nav-pills me-3" aria-orientation="vertical">
                <img class="navLogo" src="includes/logos/DC_Logo.png" alt="" srcset="">
                <a class="nav-link active" data-toggle="pill" href="#v-pills-home"><i class="bi bi-house-fill"></i> Home</a>
                <a class="nav-link" data-toggle="pill" href="#v-pills-disabled" ><i class="bi bi-search"></i> Procurar</a>
                <a class="nav-link" data-toggle="pill" href="#v-pills-messages"><i class="bi bi-collection-play-fill"></i> Biblioteca</a>
                <a data-toggle="pill" href="#v-pills-album">Menu 3</a>
                <!-- <button class="nav-link" id="v-pills-profile-tab" data-bs-toggle="pill" data-bs-target="#v-pills-profile" type="button" role="tab" aria-controls="v-pills-profile" aria-selected="false">Perfil</button> -->
                <!-- <button class="nav-link" id="v-pills-settings-tab" data-bs-toggle="pill" data-bs-target="#v-pills-settings" type="button" role="tab" aria-controls="v-pills-settings" aria-selected="false">Settings</button> -->
            </div>
            <?php include("includes/webpage/footer.php") ?>
            <div class="tab-content" id="v-pills-tabContent">
                <div class="tab-pane fade show active" id="v-pills-home"><?php include("home.php") ?></div>
                <div class="tab-pane fade" id="v-pills-disabled">...</div>
                <div class="tab-pane fade" id="v-pills-messages">...</div>
                <div class="tab-pane fade" id="v-pills-album">YEY</div>
                <!-- <div class="tab-pane fade" id="v-pills-profile" role="tabpanel" aria-labelledby="v-pills-profile-tab" tabindex="0">...</div> -->
                <!-- <div class="tab-pane fade" id="v-pills-settings" role="tabpanel" aria-labelledby="v-pills-settings-tab" tabindex="0">...</div> -->
            </div>
        </div>
    </body>
</html>