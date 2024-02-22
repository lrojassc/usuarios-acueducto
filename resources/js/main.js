const logo = document.getElementById("logo");
const barraLateral = document.querySelector(".barra-lateral");
const spans = document.querySelectorAll("span");
const palanca = document.querySelector(".switch");
const circulo = document.querySelector(".circulo");
const menu = document.querySelector(".menu");
const main = document.querySelector("main");

menu.addEventListener("click", () => {
    console.log('aqui')
    barraLateral.classList.toggle("max-barra-lateral");
    const isMaxBarraLateral = barraLateral.classList.contains("max-barra-lateral");
    menu.children[0].style.display = isMaxBarraLateral ? "none" : "block";
    menu.children[1].style.display = isMaxBarraLateral ? "block" : "none";

    if (window.innerWidth <= 320) {
        barraLateral.classList.add("mini-barra-lateral");
        main.classList.add("min-main");
        spans.forEach((span) => span.classList.add("oculto"));
    }
});

logo.addEventListener("click", () => {
    console.log('ahora aqui')
    barraLateral.classList.toggle("mini-barra-lateral");
    main.classList.toggle("min-main");
    spans.forEach((span) => span.classList.toggle("oculto"));
});
