export let ru = {
    messages: {
        required: function(n) {
            return 'Поле обязательно для заполнения';
        },
        alpha: function(n) {
            return 'Поле не должно содержать цифр';
        },
        regex: function(n) {
            return 'Поле введено некорректно';
        },
        max: function (e, n) {
            return 'Превышено максимальное количество символов в '+n[0]+' символов';
        },
        min: function (e, n) {
            return 'Минимальное количество символов '+n[0];
        },
        numeric: function (n) {
            return 'Поле должно быть числовым';
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
