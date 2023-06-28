//  Ce module servira pour tous les formulaires de modification (condoléance, post, commentaire, mot)
import Like from './Like.js'
import Submit from './Submit.js'
import {openDialogToDeleteElements} from './Delete.js'
import Report from './Report.js'
import { addEventListenerToModifyBtn } from "./ModifyButton.js";

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

                  addEventListenerToModifyBtn();
                 
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


                  openDialogToDeleteElements()

                  const reportElements = [].slice.call(document.querySelectorAll('.report-flag'));
                  if(reportElements){
                      new Report(reportElements);
                  }

                  console.log(document.querySelector('.js-submit-form'))
                  console.log(document.querySelector('#formulaire115'))

                })
                .catch(e => console.log(e));

        // })

    }) 

    })
  }

}
