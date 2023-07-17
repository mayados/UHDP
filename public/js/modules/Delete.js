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

    