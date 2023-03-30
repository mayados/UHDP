
import Filter from './modules/Filter.js'
import Like from './modules/Like.js'
import Favoris from './modules/Favoris.js'
import Submit from './modules/Submit.js'


// On passe l'élément que l'on veut rendre AJAX
new Filter(document.querySelector('.js-filter'))

new Submit(document.querySelector('.js-auto-refresh'))
// console.log(document.querySelector('.js-auto-refresh'))

document.addEventListener('DOMContentLoaded', () => {
    // const likeElements = [].slice.call(document.querySelectorAll('.like-button'));
    // if(likeElements){
    //     new Like(likeElements);
    // }

    // const favorisElements = [].slice.call(document.querySelectorAll('.favoris-button'));
    // if(favorisElements){
    //     new Favoris(favorisElements);
    // }

    // const recherche = document.querySelector('.recherche');
    // const searchLink = document.querySelector('.search-link');
    // const close = document.querySelector('.close');


    // searchLink.addEventListener('click', e =>{
    //     e.preventDefault();
    //     recherche.classList.add('visible');
    //     searchLink.style.display='none'
    // })

    // close.addEventListener('click', e =>{
    //     e.preventDefault();
    //     recherche.classList.remove('visible');
    //     searchLink.style.display='inline-block'
    // })

})

// const form = document.querySelector('.js-submit-form')
// form.addEventListener('submit', e => {
//     e.preventDefault();
//     // console.log('je n ai plus de defaut')
//     console.log(form.action)
//     const url = form.action
//     console.log(url +'11')
//     fetch(url, {
//         headers: {
//           //  Permet de différencier une requête classique d'une requête AJAX
//           'X-Requested-With': 'XMLHttpRequest',
//         // 'Content-Type': 'application/json',
//         },
//         body: new FormData(e.target),
//         method: 'POST',
//     })
//     .then(async (response) => {
//         console.log(response)
//         const data = await response.json();
//     })
//     .catch(e => alert(e));

// })