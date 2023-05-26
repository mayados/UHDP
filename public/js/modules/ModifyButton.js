// Est utilisé pour afficher le formulaire de modification d'élément (post, condoléance, commentaire, mot)
export function addEventListenerToModifyBtn(){
    const modifyButtons = document.querySelectorAll('.modify-button');
    modifyButtons.forEach(function(button) {
        button.addEventListener('click', function() {           
            // console.log(this.id)
            console.log("je suis cliqué")
            const idButton = this.id;
            CKEDITOR.replace( 'texte_edit'+idButton, {
                toolbar: [
                    { name:'styles', items:[ 'Bold' , 'Italic' , 'Underline' , 'Strike' , '-' , '-' , '-'  , '-' , '-' , '-' , '-' , 'TextColor' , '/' , 'FontSize' , 'Smiley', ]}
                ]
            } );
            CKEDITOR.add 
            const formulaire = document.querySelector("#form"+idButton);
            const condoleanceTexte = document.querySelector("#condoleance"+idButton)
            const formulaireClass = formulaire.className;
            formulaire.classList.remove('modify-form');
            formulaire.classList.add('modify-form-visible');
            condoleanceTexte.style.display='none';
            // console.log(formulaire)

            const idClose = document.querySelector("#close"+idButton);

            const formElement = document.querySelector('#formulaire'+idButton)
            const btnModifier = document.querySelector('#soumettre'+idButton)
            // console.log(btnModifier)

            // btnModifier.addEventListener('click', e => {
            //     e.preventDefault();
          
            // })
            // La requête retourne une page en json car ca n'arrive pas à détecter l'évènment sur le bouton, du coup le js n'est pas pris en compte, c'est le click direct qui est pris en compte


            // console.log(idClose)
    
            idClose.addEventListener('click', e =>{
                e.preventDefault();
                // console.log(this.href)
                formulaire.classList.add('modify-form');
                formulaire.classList.remove('modify-form-visible')
                condoleanceTexte.style.display='block';
            })  
        })
    })}