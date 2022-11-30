function abrirFecharNovaAnotacao() {
    let novaAnotacao = document.getElementById("nova-anotacao")
    let teste = document.getElementById("teste")
    novaAnotacao.style.display = novaAnotacao.style.display == "none" ? "grid" : "none"

    if (novaAnotacao.style.display == "none") {
        teste.innerText = "Nova anotação"
    }else {
        teste.innerText = "Fechar"
    }
}

function abrirCadastro() {
    document.getElementById("teste3").style.display = "flex"
}

function fecharCadastro() {
    document.getElementById('teste3').style.display = "none"
}

function fecharCadastroCliente() {
    document.getElementById('teste4').style.display = "none"
}

function abrirCadastroCliente() {
    document.getElementById("teste4").style.display = "flex"
}

function abrirEditaVendedor() {
    document.getElementById("display-editar-produto").style.display = "flex"
}

function fecharEditaVendedor() {
    document.getElementById("display-editar-produto").style.display = "none"
}