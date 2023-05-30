//  Ce module servira pour tous les formulaires de modification (condoléance, post, commentaire, mot)

/*
    A prendre pour créer le module : les pages ayant une certaine classe pour dire ce qu'on cible
    Les éléments : le formulaire de modification (qui devra envoyer les infos au serveur et se recharger)
    La zone de commentaires, posts, condoléances ou mots, qui devront s'actualiser pour afficher la modification ainsi que remettre à 0 les actions js
*/

/* Le clic retourne une page en json car ca n'arrive pas à détecter l'évènment sur le bouton, du coup le js n'est pas pris en compte, 
donc la requête ajax non plus, c'est le click direct qui est pris en compte */


import Like from './Like.js'
import Submit from './Submit.js'

/**
 * @property {HTMLElement} content
 */
export default class Modify {

  /**
   * @param {HTMLElement|null} element 
   */
  constructor(modifyFormsElements) {
    this.content = document.querySelector('.js-auto-refresh-content')  
    this.modifyFormsElements = modifyFormsElements  
    if (modifyFormsElements ) {
        this.bindEvents()      
    }


  }


  bindEvents() {

    // Ce cas est différent de celui de Submit car il y a plusieurs formulaires. Si on ne met pas d'écouteur d'évènement, , seul le premier sera toujours pris
    this.modifyFormsElements.map(form => {
        const formAction = form.action
        const idForm = form.id
        // const modifyBtn = document.querySelector('#soumettre'+idForm)

        form.addEventListener('submit', e => {
            e.preventDefault();
            console.log("moi, le bouton de soumission, je suis cliqué")
            let instanceName = ""
            let instance = ""
            let textareaValue = ""
            for (var i in CKEDITOR.instances) {
              instance = CKEDITOR.instances[i]
              instanceName = CKEDITOR.instances[i].name
              textareaValue = CKEDITOR.instances[i].getData();
      
            }
      
            instance.updateElement();
        

            const data = new FormData(form)
            data.append(instanceName, textareaValue)
      
            // On crée une nouvelle URL à partir de l'url courante
            const url = new URL(formAction|| window.location.href)
            const params = new URLSearchParams()

            // console.log(form.action)
      
            data.forEach((value, key) => {
              console.log(key, value)
              params.append(key, value)
            })

            fetch(url, {
                headers: {
                  //  Permet de différencier une requête classique d'une requête AJAX
                  'X-Requested-With': 'XMLHttpRequest',
        
                },
                // data : data,
                body: data,
                method: 'POST',
              })
                // .then(response => response.json())
                // Lorsque la promesse provenant de .json aboutit, on récupère ce qui a été traité par le JSON
                .then(async (response) => {
                  //  console.log(response)
                  const data = await response.json();

                //   console.log(data)
                instance.setData("")
                console.log(instance)
                  this.content.innerHTML = data.content
        
                  const modifyButtons = document.querySelectorAll('.modify-button');
                  modifyButtons.forEach(function(button) {
                      button.addEventListener('click', function() {           
                          // console.log(this.id)
                          // console.log("je suis cliqué")
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
                          console.log(formulaire)
              
                          const idClose = document.querySelector("#close"+idButton);
              
                          // console.log(idClose)
                  
                          idClose.addEventListener('click', e =>{
                              e.preventDefault();
                              console.log(this.href)
                              formulaire.classList.add('modify-form');
                              formulaire.classList.remove('modify-form-visible')
                              condoleanceTexte.style.display='block';
                          })  
                      })
                  })


                  // console.log(data.content)                    
        
                  const likeElements = [].slice.call(document.querySelectorAll('.like-button'));
                  if(likeElements){
                      new Like(likeElements);
                  }

                  const modifyFormsElements = [].slice.call(document.querySelectorAll('.js-modify-form'))
                  // console.log(modifyFormsElements)
                  if(modifyFormsElements){
                      new Modify(modifyFormsElements);
                  }
                  //  CKEDITOR.instances['condoleance_texte'].updateElement()
                  // new Submit(document.querySelector('.js-refresh-page'))


                  console.log(document.querySelector('.js-submit-form'))
                  console.log(document.querySelector('#formulaire115'))

                })
                .catch(e => console.log(e));

        // })

    }) 

    })
  }

}
