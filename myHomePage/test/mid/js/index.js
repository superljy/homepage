var mainCon = document.getElementById("mainCon"),
    v300 = document.getElementById("v300"),
    v100 = document.getElementById("v100"),
    mainConImg = mainCon.getElementsByTagName("img")[0],
    v300Img = v300.getElementsByTagName("img")[0],
    v100Img = v100.getElementsByTagName("img")[0],
    boxMain = document.getElementById("boxMain"),
    boxV300 = document.getElementById("boxV300"),
    boxV100 = document.getElementById("boxV100");

document.onclick = function(e){
    if (e.target.id === "mainCon"){
        boxMain.style.display = "block";
        boxV300.style.display = boxV100.style.display = "none";
        mainConImg.src = "./images/tipcon-highlight.png";
        v300Img.src = "./images/tip300.png";
        v100Img.src = "./images/tip100.png";
    }
    if (e.target.id === "v300"){
        boxV300.style.display = "block";
        boxMain.style.display = boxV100.style.display = "none";
        mainConImg.src = "./images/tipcontent.png";
        v300Img.src = "./images/tip300-highlight.png";
        v100Img.src = "./images/tip100.png";
    }

    if (e.target.id === "v100"){
        boxV100.style.display = "block";
        boxMain.style.display = boxV300.style.display = "none";
        mainConImg.src = "./images/tipcontent.png";
        v300Img.src = "./images/tip300.png";
        v100Img.src = "./images/tip100-highlight.png";
    }
};
