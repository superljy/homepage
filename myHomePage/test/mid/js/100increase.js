var mainCon = document.getElementById("mainCon"),
    i100 = document.getElementById("i300"),
    v100 = document.getElementById("v100"),
    mainConImg = mainCon.getElementsByTagName("img")[0],
    // i100Img = i100.getElementsByTagName("img")[0],
    v100Img = v100.getElementsByTagName("img")[0],
    boxMain = document.getElementById("boxMain"),
    boxI100 = document.getElementById("boxI100"),
    boxV100 = document.getElementById("boxV100");


document.onclick = function (e) {
    if (e.target.id === "mainCon") {
        boxMain.style.display = "block";
        boxI100.style.display = boxV100.style.display = "none";
        mainConImg.src = "./images/tipcon-highlight.png";
        v100Img.src = "./images/tip100.png";
    }
    if (e.target.id === "i100") {
        console.log("coming soon");
    }

    if (e.target.id === "v100") {
        boxV100.style.display = "block";
        boxMain.style.display = boxI100.style.display = "none";
        mainConImg.src = "./images/tipcontent.png";
        v100Img.src = "./images/tip100-highlight.png";
    }
};
