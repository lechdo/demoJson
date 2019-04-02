$(document).ready(
  function () {

      // tous les éléments dans la fonction seront éxécuté
      // une fois que la page aura fini de charger

      // on y place entres autres les déclarations dépendantes
      // d'un évenement et non d'une action, comme onClick ou onChange

      //on peut éplacer une requete lourde (bcp de données) qui ne sera
      // chargée qu'après le reste de la page
      // pratique pour la mise en forme (cf site de banque par exemple)

      // pour une déclaration dépendante d'une action, cela se passe coté
      // html, avec les attributs de balise.

  }
);

getMethod = function () {
    // vider en premier la div pour remettre une nouvelle liste
    $("#liste").empty();

    //afficher le loader
    // selection du display d'un élément
    document.getElementById("loader").style.display = "block";


    $.ajax(
        {
            //uri derriere le nom de domaine, attention sans vhost, cela ne marchera pas
            url: "/api-get",
            // le type, s'il n'est pas mentionné, ce sera GET
            type: "GET",
            // renvoie l'action en cas de succès de la requête (il existe .fail dans Jquery)
            success: () => {alert("le get a été effectué")}
        }

    )
        // executé quand la fonction est terminée
        .done(function (apiResult) {
            // nb : of et pas if, si on met if, il agira pour chaque caractère du json
            for (personne of apiResult) {
                // la méthode génératrice de template
                createHumanTemplate(personne);
            }

            // effacement du loader
            document.getElementById("loader").style.display = "none";
        })
}

postMethod = function () {
    var nom = document.getElementById("nom").value;
    var prenom = document.getElementById("prenom").value;
    var age = document.getElementById("age").value;

    // pour une demande de confirmation simple : confirm
    if (confirm("êtes vous sur de créer cette personne ?")){
        // la methode post
        $.ajax(
            {
                url: "/api-post",
                type: "POST",
                // les paramètres sont en Json dans le Json, et oui...
                // cela fonctionne de la meme manière pour les paramètres de GET
                data: {
                    nom: nom,
                    prenom: prenom,
                    age: age
                },
                success: (apiResult) => {alert(apiResult)}
            }

        )
            .done(function (apiResult) {
                createHumanTemplate()
            })
    }
}

createHumanTemplate = function (personne) {
    console.log("je suis dans la func");
    var bloc = document.createElement("tr")

    // amener un élément json dans un format html
    // creation de l'élément html
    var nom = document.createElement("td");
    // attribution d'un texte au td
    nom.innerText = "nom : " + personne.nom;
    // attribution de l'éléement au bloc parent
    bloc.appendChild(nom);

    var prenom  = document.createElement("td");
    prenom.innerText = "prenom : " + personne.prenom;
    bloc.appendChild(prenom);

    var age  = document.createElement("td");
    age.innerText = " age : " + personne.age;
    bloc.appendChild(age);

    // méthode Jquery pour insérer le bloc dans une balise en séléctionnant son id.
    $("#liste").append(bloc);
}

