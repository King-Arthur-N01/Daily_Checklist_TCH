$(document).ready(function(){
    function displayTime() {
        //peraturan waktu
        var options = {
            hour12: false,
            hourCycle: 'h12',
            timeZone: 'Asia/Jakarta'
        };
        //inisialisasi waktu
        var date = new Date();
        var time = date.toLocaleTimeString('en-US', options);
        document.getElementById("clock").textContent = time;
    }

    setInterval(displayTime, 1000);
});
