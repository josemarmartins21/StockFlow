function comprimentar(nome) {
    let hora = new Date().getHours(); // hora actual (0–23)
    let nomeHora = document.getElementById('nome-hora')
    
    // Saudação da manhã
    if (hora >= 0 && hora < 12) {   
        nomeHora.innerText = `Bom dia, ${nome}`   
    }

    // Saudação da tarde
    if (hora >= 12 && hora < 18 ) {
        nomeHora.innerText = `Boa tarde, ${nome}` 
    }

    // Saudação da noite
    if (hora > 18 && hora <= 23) {
        nomeHora.innerText = `Boa noite, ${nome}`
    }
}