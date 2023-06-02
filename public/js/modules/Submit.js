import Like from './Like.js'
import Modify from './Modify.js'
import Delete from './Delete.js'


/**
 * @property {HTMLElement} content
 * @property {HTMLFormElement} form
 */
export default class Submit {

  /**
   * @param {HTMLElement|null} element 
   */
  constructor(element) {
    if (element == null) {
      return
    }
    this.content = element.querySelector('.js-auto-refresh-content')
    this.form = element.querySelector('.js-submit-form')
    this.erreurs = element.querySelector('.custom-errors')
    // console.log(this.form)

    // this.h2 = element.querySelector('.js-refresh-like')
    // console.log(this.likes)
    this.bindEvents()
  }


  bindEvents() {

    this.form.addEventListener('submit', e => {
      e.preventDefault();

      let instanceName = ""
      let instance = ""
      let textareaValue = ""
      // console.log(CKEDITOR.instances)
      for (var i in CKEDITOR.instances) {
        if(CKEDITOR.instances[i].name == 'condoleance_texte'){
          instance = CKEDITOR.instances['condoleance_texte']
          instanceName = CKEDITOR.instances['condoleance_texte'].name
          textareaValue = CKEDITOR.instances['condoleance_texte'].getData();  
          instance.updateElement();
          instance.setData('')
        }else if(CKEDITOR.instances[i].name == 'comment_histoire_texte'){
           instance = CKEDITOR.instances['comment_histoire_texte']
           instanceName = CKEDITOR.instances['comment_histoire_texte'].name
           textareaValue = CKEDITOR.instances['comment_histoire_texte'].getData(); 
           instance.updateElement();
           instance.setData('') 

        }else if(CKEDITOR.instances[i].name == 'mot_mot'){
          instance = CKEDITOR.instances['mot_mot']
          instanceName = CKEDITOR.instances['mot_mot'].name
          textareaValue = CKEDITOR.instances['mot_mot'].getData();  
          instance.updateElement();
          instance.setData('')
        }else if(CKEDITOR.instances['post_texte']){
          instance = CKEDITOR.instances['post_texte']
          instanceName = CKEDITOR.instances['post_texte'].name
          textareaValue = CKEDITOR.instances['post_texte'].getData();  
          instance.updateElement();
          instance.setData('')
        } else if(CKEDITOR.instances['message_texte']){
          instance = CKEDITOR.instances['message_texte']
          instanceName = CKEDITOR.instances['message_texte'].name
          textareaValue = CKEDITOR.instances['message_texte'].getData();  
          instance.updateElement();
          instance.setData('')
        }
          // instance.updateElement();
          // instance.setData('')

      }
 

      // instance.updateElement();
      // CKEDITOR.replace('condoleance_texte')
      const data = new FormData(this.form)
      data.append(instanceName, textareaValue)

      // On crée une nouvelle URL à partir de l'url courante
      const url = new URL(window.location.href)
      const params = new URLSearchParams()

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

          this.content.innerHTML = data.content

          // On ajoute à nouveau un eventListener aux boutons, puisque l'appel en ajax permet juste de retrouver les éléments avec leur structure naturelle (et non avec les actions etc)
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
        
                    console.log(idClose)
            
                    idClose.addEventListener('click', e =>{
                        e.preventDefault();
                        console.log(this.href)
                        formulaire.classList.add('modify-form');
                        formulaire.classList.remove('modify-form-visible')
                        condoleanceTexte.style.display='block';
                    })  
                })
            })

          const likeElements = [].slice.call(document.querySelectorAll('.like-button'));
          if(likeElements){
              new Like(likeElements);
          }

          const modifyFormsElements = [].slice.call(document.querySelectorAll('.js-modify-form'))
          // console.log(modifyFormsElements)
          if(modifyFormsElements){
              new Modify(modifyFormsElements);
          }

          const deleteElements = [].slice.call(document.querySelectorAll('.delete'));
          if(deleteElements){
              new Delete(deleteElements);
          }

          
          // S'il y a des erreurs
          if (data.error != undefined) {

            const formError = this.form.querySelector('.custom-errors');
            const messageErreur = document.createElement("p")
            messageErreur.innerText = data.error;
            formError.appendChild(messageErreur);

          } else {
            const formError = this.form.querySelector('.custom-errors');
            formError.style.display = 'none';
            instance.setData("")
          }

        })
        .catch(e => console.log(e));
    })
  }

}
