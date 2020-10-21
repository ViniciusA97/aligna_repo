export const statusPreenchimentoIcon = (status) => {
    switch(status) {
        case 'Em construção':
            return 'icon wb-star-half';
        case 'Desatualizado':
            return 'icon wb-alert-circle';
        case 'Concluído':
            return 'icon wb-check-circle';
        case 'Inativo':
            return 'icon wb-close-mini';
    }
}

export const statusExecucaoColors = (status) => {
    switch(status) {
        case 'Está sendo executado':
            return 'green';
        case 'Está sendo parcialmente executado':
            return 'yellow';
        case 'Não está sendo executado':
            return 'red';
    }
}

export const getFirstLetter = (word) => {
    return word.charAt(0)
}
