import Like from './Like.js'
import Modify from './Modify.js'
import { addEventListenerToModifyBtn } from "./ModifyButton.js";


export default class Delete {

    /**
     * @param {HTMLElement|null} deleteElements 
     */
      constructor(deleteElements){
        this.deleteElements = deleteElements;
        this.content = document.querySelector('.delete-report');
        // var contenu = this.content
        // console.log(contenu)

          if(deleteElements){
            this.init()
          }
      }
  
      init(){
        //  On enlève la logique de base 
        this.deleteElements.map(element => {
            element.addEventListener('click', this.onClick)
        }) 
      }

      onClick(event){
        
        event.preventDefault();
        const url = new URL(this.href|| window.location.href);
        const contenu = document.querySelector('.delete-report')
        console.log(this) 
        console.log(this.content)     
        console.log(url)
        fetch(url.pathname + "?", {
            headers: {
            'X-Requested-With': 'XMLHttpRequest'
            },
            method: 'POST',
        })
            .then(response => response.json())
            .then(response => {

                console.log(contenu)
                contenu.innerHTML = response.content

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

                addEventListenerToModifyBtn();
                // this.content.innerHTML = response.content
            }).catch(e => alert(e));
      }

  }