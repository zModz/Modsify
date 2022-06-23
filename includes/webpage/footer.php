<footer id="footer">
    <div class="buttons">
        <div class="shuffle-track" onclick="shuffleTrack()">
            <i class="bi bi-shuffle"></i>
        </div>
        <div class="prev-track" onclick="prevTrack()">
            <i class="bi bi-skip-start-fill"></i>
        </div>
        <div class="playpause-track" onclick="playpauseTrack()">
            <i class="bi bi-play-circle-fill"></i>
        </div>
        <div class="next-track" onclick="nextTrack()">
            <i class="bi bi-skip-end-fill"></i>
        </div>
        <div class="repeat-track" onclick="repeatTrack()">
            <i class="bi bi-arrow-repeat"></i>
        </div>
    </div>
    
    <div class="slider_container">
        <div class="current-time">00:00</div>
        <input type="range" min="1" max="100" value="0" class="seek_slider" onchange="seekTo()">
        <div class="total-duration">00:00</div>
    </div>

    <div class="slider_container">
        <i class="fa fa-volume-down"></i>
        <input type="range" min="1" max="100" value="99" class="volume_slider" onchange="setVolume()">
        <i class="fa fa-volume-up"></i>
    </div>
</footer>