
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

    const message = document.querySelector('#ajout-message');
    if(message){
        const formulaireCondoleances = document.querySelector('#container-form-condoleances');
        const close = document.querySelector('.close');

        message.addEventListener('click', e =>{
            e.preventDefault();
            formulaireCondoleances.style.display='block';
            message.style.display='none'
        })
    }

    let mesBrouillonsLink = document.querySelector('#mesBrouillonsLink');
    let mesAttentesLink = document.querySelector('#mesAttentesLink');    
    let mesPublieesLink = document.querySelector('#mesPublieesLink');    
    let mesDesapprouveesLink = document.querySelector('#mesDesapprouveesLink');    
    if(mesBrouillonsLink || mesAttentesLink || mesPublieesLink || mesDesapprouveesLink){
        let mesBrouillons = document.querySelector('#histoires-brouillon');
        let mesAttentes = document.querySelector('#histoires-en-attente');        
        let mesPubliees = document.querySelector('#histoires-publiees');        
        let mesDesapprouvees = document.querySelector('#histoires_desapprouvees');        
        // console.log('uhuh')
        mesBrouillonsLink.addEventListener('click',e =>{
            e.preventDefault();
            mesBrouillons.style.display='block';
            mesAttentes.style.display='none';
            mesPubliees.style.display='none';
            mesDesapprouvees.style.display='none';
        })

        mesAttentesLink.addEventListener('click',e =>{
            e.preventDefault();
            mesAttentes.style.display='block';
            mesBrouillons.style.display='none';
            mesPubliees.style.display='none';
            mesDesapprouvees.style.display='none';
        })        

        mesPublieesLink.addEventListener('click',e =>{
            e.preventDefault();
            mesBrouillons.style.display='none';
            mesAttentes.style.display='none';
            mesPubliees.style.display='block';
            mesDesapprouvees.style.display='none';
        })        

        mesDesapprouveesLink.addEventListener('click',e =>{
            e.preventDefault();
            mesBrouillons.style.display='none';
            mesAttentes.style.display='none';
            mesPubliees.style.display='none';
            mesDesapprouvees.style.display='block';
        })        
    }


})

