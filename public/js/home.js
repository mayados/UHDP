/* CAROUSLEL */

let compteur = 0
let timer, carouselElements, slides, slideWidth
// Pour être sûr que le docuement soit chargé avant d'effectuer le script
window.onload = () => {
    const carousel = document.querySelector('#carousel')
    carouselElements = document.querySelector('.carousel-elements')
    // On récupère tous les enfants de carouselElements => toutes les div .element qui contiennent les photos du slider
    slides = Array.from(carouselElements.children)

    // Pour calculer la largeur du carousel
    slideWidth = carousel.getBoundingClientRect().width

    let next = document.querySelector('#nav-droite')
    next.addEventListener("click",slideNext)

    let previous = document.querySelector('#nav-gauche')
    previous.addEventListener("click",slidePrevious)

    // Gérer le redimensionnement de la taille de fenêtre grâce à un évènement js
    window.addEventListener("resize", () => {
        // On recalcule la taille du carousel lors d'un cahngement de taille de fenêtre pour avoir la bonne taille
        slideWidth = carousel.getBoundingClientRect().width
    })

    /* Automatiser le diaporama */
    timer = setInterval(slideNext,4000);

    //Gérer le survol pour ne pas que le timer gêne l'interraction avec les flèches
    // carousel.addEventListener('mouseover',stopTimer)
    // carousel.addEventListener('mouseout',startTimer)

}

function slideNext()
{
    compteur++
    if(compteur == slides.length){
        compteur = 0
    }
    // On doit décaler l'image vers la gauche pour que l'image de droite puisse s'afficher
    // On calcule la largeur d'une slide et la multiplier par le compteur
    let decal = -slideWidth * compteur
    carouselElements.style.transform = `translateX(${decal}px)`
}

function slidePrevious()
{
    compteur--
    if(compteur < 0 ){
        compteur = slides.length - 1
    }
    // On doit décaler l'image vers la droite pour que l'image de gauche puisse s'afficher
    // On calcule la largeur d'une slide et la multiplier par le compteur
    let decal = -slideWidth * compteur
    carouselElements.style.transform = `translateX(${decal}px)`
}

function stopTimer(){
    clearInterval(timer);
}

function startTimer(){
    timer = setInterval(slideNext,4000);
}