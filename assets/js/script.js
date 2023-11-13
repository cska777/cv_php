document.addEventListener("DOMContentLoaded" , ()=>{
    document.getElementById("inscriptionForm").addEventListener("submit",(e)=>{
        let isValid = true;

        // On réinitialise le message d'erreur

        document.querySelectorAll(".error").forEach((errorDiv)=>{
            errorDiv.textContent = " "
        })

        // On récupère les valeurs du formulaire

        let prenom = document.getElementById("prenom").value
        let nom = document.getElementById("nom").value
        let mail = document.getElementById("email").value
        let mdp = document.getElementById("mdp").value
        let mdpConfirm = document.getElementById("mdpConfirm").value

        // On vérifie que les champs sont rempli et valide

        if(!prenom){
            document.getElementById("errorPrenom").textContent = "Veuillez renseigner le prénom"
            document.getElementById("prenom").style.border = "1px solid red"
            isValid = false
        }

        else if(prenom.length < 2){
            document.getElementById("errorPrenom").textContent = "Le prénom doit contenir au moins 2 lettres"
            document.getElementById("prenom").style.border = "1px solid red"
            isValid = false
        }

        if(!nom){
            document.getElementById("errorNom").textContent = "Veuillez renseigner le nom"
            document.getElementById("nom").style.border = "1px solid red"
            isValid = false
        }

        else if(nom.length < 2){
            document.getElementById("errorNom").textContent = "Le nom doit contenir au moins 2 lettres"
            document.getElementById("nom").style.border = "1px solid red"
            isValid = false
        }   

        if(!mail){
            document.getElementById("errorMail").textContent = 
            "Veuillez renseigner une adresse mail"
            document.getElementById("mail").style.border = "1px solid red"
            isValid = false
        }
        else if(!/^[A-Z0-9._%+-]+@[A-Z0-9.-]+\.[A-Z]{2,}$/i.test(mail)){
            document.getElementById("errorMail").textContent = "Veuillez renseinger une adresse mail valide"
            document.getElementById("mail").style.border = "1px solid red"
            isValid = false
        }
        if(!mdp){
            document.getElementById("errorMdp").textContent = "Un mot de passe est obligatoire"
            document.getElementById("mdp").style.border = "1px solid red"
        }

        else if(mdp.length < 8){
            document.getElementById("errorMdp").textContent = "Votre mot de passe doit contenir au moins 8 caractères"
            document.getElementById("mdp").style.border = "1px solid red"
        }

        if (!mdpConfirm) {
            document.getElementById("errorMdpConfirm").textContent = "Le mot de passe de confirmation est requis.";
            document.getElementById("mdpConfirm").style.border = "1px solid red";
            isValid = false;
        }
        else if (mdp !== mdpConfirm) {
            document.getElementById("errorMdpConfirm").textContent = "Les mots de passe ne correspondent pas.";
            document.getElementById("mdpConfirm").style.border = "1px solid red";
            isValid = false;
        }

        if(!isValid){
            e.preventDefault()
        }
    })
})