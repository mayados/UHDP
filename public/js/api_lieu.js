                /* Une fois que les éléments de la page sont chargés, le code JavaScript peut s'exécuter */
        window.addEventListener('DOMContentLoaded', (event) => {
            var inputLieu = document.querySelector('#memorial_lieu');
            /* il vaut mieux utiliser l'évènement input que les events keyboard, car les events keyboard risquent de ne pas
            détecter les touches d'un clavier tactile (tablette / mobile), ni la reconnaissance vocale */
            inputLieu.addEventListener("focusout", (event) => {
                let searchValue = inputLieu.value;   
                event.preventDefault();
                removeListe();       
                getInfos(searchValue);
            })

            function getInfos(searchValue){
                // S'il n'y a pas de valeur on ne return rien, et les éléments au bas de la fonction ne s'exécutent pas
                if(searchValue == '') return;  
                const url = "/villes";  
                fetch(url, {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/x-www-form-urlencoded',
                        'Accept': '*/*'
                    },
                    body: new URLSearchParams({
                        'searchValue': searchValue
                    })
                })   
                .then(async (response) => {
                    const data = await response.json();
                    var liste = document.createElement("ul");
                    liste.id = "autocomplete-list"
                    inputLieu.appendChild(liste)                          
                        data.forEach(ville => {
                            let listItem = document.createElement("li")
                            let listItemButton = document.createElement("button")
                            listItemButton.innerHTML = ville.nom +" ("+ ville.departement.code +"-"+ ville.departement.nom+")"
                            listItemButton.addEventListener("click", clickListItemButton)                  
                            listItem.appendChild(listItemButton)
                            liste.appendChild(listItem) 
                                               
                        });
                    document.querySelector("#form-lieu").appendChild(liste)                    
                })
            }
            function removeListe(){
                var liste = document.querySelector("#autocomplete-list")
                // Si la liste existe, on la retire du document
                // liste.remove()
                if(liste){
                    liste.remove();
                }
            }

            function clickListItemButton(e){
                // preventDefault permet d'enlever le comportement par défaut du déclencheur de l'event (ici, le bouton) : il ne submit donc rien
                e.preventDefault;
                // On récupère ce qui a actionnée l'event => c'est le listItemButton
                const listButton = e.target;
                inputLieu.value = listButton.innerHTML;
                removeListe();
            }
        })