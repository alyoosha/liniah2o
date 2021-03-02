export let ro = {
    messages: {
        required: function(n) {
            return 'Câmp necesar';
        },
        alpha: function(n) {
            return 'Câmpul nu trebuie să conțină numere';
        },
        regex: function(n) {
            return 'Câmpul este introdus incorect';
        },
        max: function (e, n) {
            return 'A depășit numărul maxim de caractere din '+n[0]+' caractere';
        },
        min: function (e, n) {
            return 'Minim '+n[0]+ ' caractere';
        },
        numeric: function (n) {
            return 'Câmpul trebuie să fie numeric';
        }
    },
    attributes: {
        required: 'required',
        alpha: 'alpha',
        regex: 'regex',
        max: 'max',
        min: 'min',
        numeric: 'numeric',
    }
};
