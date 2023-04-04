
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

})

