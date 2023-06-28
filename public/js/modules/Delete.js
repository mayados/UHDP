    // Suppression de commentaires, condoléances, posts, mots..
    export function openDialogToDeleteElements(){
        let preDeleteButtons = document.querySelectorAll('.open-dialog');
        if(preDeleteButtons){
            preDeleteButtons.forEach(function(element) {
                const idElement = element.id    
                console.log(idElement)                    
                let dialog = document.getElementById('dialog'+idElement);
                let annuler = document.getElementById('annuler'+idElement)
                element.addEventListener('click', function onOpen() {
                    if (typeof dialog.showModal === "function") {
                        // e.preventDefault();
                        dialog.showModal();
                        // Le close peut être détecté car dans le formulaire l'attribut method est définit sur "dialog"
                        element.addEventListener('close', function onClose(){
                        })
            
                    } else {
                        console.error("L'API <dialog> n'est pas prise en charge par ce navigateur.");
                    } 

                })

            })        
        }
    }

    
// import Like from './Like.js'
// import Modify from './Modify.js'
// import { addEventListenerToModifyBtn } from "./ModifyButton.js";
// import Report from './Report.js'



// export default class Delete {

//     /**
//      * @param {HTMLElement|null} deleteElements 
//      */
//       constructor(deleteElements){
//         this.deleteElements = deleteElements;
//         this.content = document.querySelector('.delete-report');
//         // var contenu = this.content
//         // console.log(contenu)

//           if(deleteElements){
//             this.init()
//           }
//       }
  
//       init(){
//         //  On enlève la logique de base 
//         this.deleteElements.map(element => {
//             element.addEventListener('click', this.onClick)
//         }) 
//       }

//       onClick(event){
        
//         event.preventDefault();
//         const url = new URL(this.href|| window.location.href);
//         const contenu = document.querySelector('.delete-report')
//         // console.log(this) 
//         // console.log(contenu)     
//         console.log(url.pathname)
//         fetch(url.pathname + "?", {
//             headers: {
//             'X-Requested-With': 'XMLHttpRequest'
//             },
//             method: 'POST',
//         })
//             .then(response => response.json())
//             .then(response => {

//                 console.log(response)
//                 contenu.innerHTML = response.content

//                 const likeElements = [].slice.call(document.querySelectorAll('.like-button'));
//                 if(likeElements){
//                     new Like(likeElements);
//                 }
      
//                 const modifyFormsElements = [].slice.call(document.querySelectorAll('.js-modify-form'))
//                 // console.log(modifyFormsElements)
//                 if(modifyFormsElements){
//                     new Modify(modifyFormsElements);
//                 }

//                 const deleteElements = [].slice.call(document.querySelectorAll('.delete'));
//                 if(deleteElements){
//                     new Delete(deleteElements);
//                 }

//                 const reportElements = [].slice.call(document.querySelectorAll('.report-flag'));
//                 if(reportElements){
//                     new Report(reportElements);
//                 }

//                 addEventListenerToModifyBtn();
//                 // this.content.innerHTML = response.content
//             }).catch(e => console.log((e)));
//       }

//   }