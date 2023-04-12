
import Filter from './modules/Filter.js'
import Like from './modules/Like.js'
import Favoris from './modules/Favoris.js'
import Submit from './modules/Submit.js'


// On passe l'élément que l'on veut rendre AJAX
new Filter(document.querySelector('.js-filter'))

new Submit(document.querySelector('.js-refresh-page'))
// console.log(document.querySelector('.js-auto-refresh'))

document.addEventListener('DOMContentLoaded', () => {
    const likeElements = [].slice.call(document.querySelectorAll('.like-button'));
    if(likeElements){
        new Like(likeElements);
    }

    const favorisElements = [].slice.call(document.querySelectorAll('.favoris-button'));
    if(favorisElements){
        new Favoris(favorisElements);
    }

    const recherche = document.querySelector('.recherche');
    if(recherche){
        const searchLink = document.querySelector('.search-link');
        const close = document.querySelector('.close');


        searchLink.addEventListener('click', e =>{
            e.preventDefault();
            recherche.classList.add('visible');
            searchLink.style.display='none'
        })

        close.addEventListener('click', e =>{
            e.preventDefault();
            recherche.classList.remove('visible');
            searchLink.style.display='inline-block'
        })        
    }

    let mesMemoriauxLink = document.querySelector('#mesMemoriauxLink');
    let mesHistoiresLink = document.querySelector('#mesHistoiresLink');    
    let mesTopicsLink = document.querySelector('#mesTopicsLink');    
    let mesFavorisLink = document.querySelector('#mesFavorisLink');    
    if(mesMemoriauxLink || mesHistoiresLink || mesTopicsLink){
        let mesMemoriaux = document.querySelector('#mes-memoriaux');
        let mesHistoires = document.querySelector('#mes-histoires');        
        let mesTopics = document.querySelector('#mes-topics');        
        let mesFavoris = document.querySelector('#mes-favoris');        
        // console.log('uhuh')
        mesMemoriauxLink.addEventListener('click',e =>{
            e.preventDefault();
            mesMemoriaux.style.display='block';
            mesHistoires.style.display='none';
            mesTopics.style.display='none';
            mesFavoris.style.display='none';
        })

        mesHistoiresLink.addEventListener('click',e =>{
            e.preventDefault();
            mesHistoires.style.display='block';
            mesMemoriaux.style.display='none';
            mesTopics.style.display='none';
            mesFavoris.style.display='none';
        })        

        mesTopicsLink.addEventListener('click',e =>{
            e.preventDefault();
            mesTopics.style.display='block';
            mesMemoriaux.style.display='none';
            mesHistoires.style.display='none';
            mesFavoris.style.display='none';
        })        

        mesFavorisLink.addEventListener('click',e =>{
            e.preventDefault();
            mesFavoris.style.display='block';
            mesTopics.style.display='none';
            mesMemoriaux.style.display='none';
            mesHistoires.style.display='none';
        })        
    }


})

