
import Filter from './modules/Filter.js'
import Like from './modules/Like.js'
import {openDialogToDeleteElements} from './modules/Delete.js'
import Favoris from './modules/Favoris.js'
import Submit from './modules/Submit.js'
import Modify from './modules/Modify.js'
import Report from './modules/Report.js'
import { addEventListenerToModifyBtn } from "./modules/ModifyButton.js";
// import { postModifyForm } from "./modules/Modify.js";


document.addEventListener('DOMContentLoaded', () => {

    // Menu burger
    var toggleButton = document.querySelector('.toggle-menu');
    var navBar = document.querySelector('.nav-bar');
    var toggleLine = document.querySelector('.line');
    toggleButton.addEventListener('click', function () {
        navBar.classList.toggle('toggle');
        toggleButton.classList.toggle('toggle');
    });

    if(document.querySelector('.close-alert')){
        var closeAlert = document.querySelector('.close-alert')
        closeAlert.addEventListener('click', e =>{
            e.preventDefault();
        let alertMessage = document.querySelector('.alert-message')
            alertMessage.style.display="none";
        })
    }

        // On passe l'élément que l'on veut rendre AJAX
    if(document.querySelector('.js-filter')){
        new Filter(document.querySelector('.js-filter'))    
    }

    const likeElements = [].slice.call(document.querySelectorAll('.like-button'));
    if(likeElements){
        new Like(likeElements);
    }

    const favorisElements = [].slice.call(document.querySelectorAll('.favoris-button'));
    if(favorisElements){
        new Favoris(favorisElements);
    }

    const reportElements = [].slice.call(document.querySelectorAll('.report-flag'));
    if(reportElements){
        new Report(reportElements);
    }
    

    openDialogToDeleteElements();
    

    if(document.querySelector('.js-refresh-page')){
        new Submit(document.querySelector('.js-refresh-page'))    
    }
    
    // suppression d'un élement (compte, histoire, mémorial, topic...)
    let preDeleteButton = document.getElementById('open-dialog');
    if(preDeleteButton){
        let dialog = document.getElementById('delete-dialog');
        let annuler = document.querySelector('#annuler')
        // Le bouton "Mettre à jour les détails" ouvre le <dialogue> ; modulaire
        preDeleteButton.addEventListener('click', function onOpen() {
        if (typeof dialog.showModal === "function") {
            dialog.showModal();
            // Le close peut être détecté car dans le formulaire l'attribut method est définit sur "dialog"
            preDeleteButton.addEventListener('close', function onClose(){
            })
 
        } else {
            console.error("L'API <dialog> n'est pas prise en charge par ce navigateur.");
        }
        });        
    }
    

    var shareCircles = document.querySelectorAll('.share-content')

    if(shareCircles){
        shareCircles.forEach(function(circle){
            circle.addEventListener('click', function() {
                if(circle.offsetHeight === 30){
                    console.log("je fais 30cm")
                    var innerContent = circle.querySelector('.share-content-inner')
                    innerContent.classList.remove(".share-content-inner")
                    innerContent.classList.add('share-content-inner-open')
                    circle.classList.remove('share-content')
                    circle.classList.add('share-content-open')                       
                }else{
                    console.log(circle.style.height)
                    var innerContent = circle.querySelector('.share-content-inner-open')
                    innerContent.classList.remove("share-content-inner-open")
                    innerContent.classList.add('share-content-inner')
                    circle.classList.remove('share-content-open')
                    circle.classList.add('share-content')          
                }
            })
        })
    }

    const modifyFormsElements = [].slice.call(document.querySelectorAll('.js-modify-form'))
    if(modifyFormsElements){
        new Modify(modifyFormsElements);
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

        close.addEventListener('click', e =>{
            e.preventDefault();
            formulaireCondoleances.style.display='none';
            message.style.display='block'
        })        
    }

    const addPhoto = document.querySelector('#ajout-photo');
    if(addPhoto){
        const formPhoto = document.querySelector('#form-photo');
        const close = document.querySelector('.close-form');

        addPhoto.addEventListener('click', e =>{
            e.preventDefault();
            formPhoto.style.display='block';
            addPhoto.style.display='none'
        })

        close.addEventListener('click', e =>{
            e.preventDefault();
            formPhoto.style.display='none';
            addPhoto.style.display='block'
        })        
    }

    const addCommentaire = document.querySelector('#ajout-commentaire');
    if(addCommentaire){
        const formCommentaire = document.querySelector('#ajout-commentaire-form');
        const close = document.querySelector('.close');

        addCommentaire.addEventListener('click', e =>{
            e.preventDefault();
            formCommentaire.style.display='block';
            addCommentaire.style.display='none'
        })

        close.addEventListener('click', e =>{
            e.preventDefault();
            formCommentaire.style.display='none';
            addCommentaire.style.display='block'
        })        
    }

    const addMot = document.querySelector('#ajout-mot-link');
    if(addMot){
        const formMot = document.querySelector('#ajout-mot-form');
        const close = document.querySelector('.close');

        addMot.addEventListener('click', e =>{
            e.preventDefault();
            formMot.style.display='block';
            addMot.style.visibility='hidden'
        })

        close.addEventListener('click', e =>{
            e.preventDefault();
            formMot.style.display='none';
            addMot.style.visibility='visible'
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

    addEventListenerToModifyBtn();

})
