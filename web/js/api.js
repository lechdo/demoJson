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
    $.ajax(
        {
            url: "/api-get",
            type: "GET",
            // les paramètres sont en Json dans le Json, et oui...
            data: {
                nom: nom,
                prenom: prenom,
                age: age
            },
            //contentType: "json",
            success: () => {alert("ça marche !")}
        }

    )
        .done(function () {
            createHumanTemplate()
        })
}

postMethod = function () {
    var nom = document.getElementById("nom").value;
    console.log(nom);
    var prenom = document.getElementById("prenom").value;
    console.log(prenom);
    var age = document.getElementById("age").value;
    console.log(age);
    $.ajax(
        {
            url: "/api-post",
            type: "POST",
            // les paramètres sont en Json dans le Json, et oui...
            data: {
                nom: nom,
                prenom: prenom,
                age: age
            },
            success: () => {alert("ça marche !")}
        }

    )
        .done(function () {
            createHumanTemplate()
        })
}

createHumanTemplate = function () {
    var bloc = document.createElement("div")

    var nom;
    var prenom;
    var age;

    // méthode pour insérer le bloc dans une balise en séléctionnant son id.
    //$().append();
}

// selection du display d'un élément
//document.getElementById().style.display