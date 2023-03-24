
import Filter from './modules/Filter.js'
import Like from './modules/Like.js'
import Favoris from './modules/Favoris.js'


// On passe l'élément que l'on veut rendre AJAX
new Filter(document.querySelector('.js-filter'))

document.addEventListener('DOMContentLoaded', () => {
    const likeElements = [].slice.call(document.querySelectorAll('.like-button'));
    if(likeElements){
        new Like(likeElements);
    }

    const favorisElements = [].slice.call(document.querySelectorAll('.favoris-button'));
    if(favorisElements){
        new Favoris(favorisElements);
    }
})