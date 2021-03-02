export var ntc = {
    init: function() {
        var color, rgb, hsl;
        for(var i = 0; i < ntc.names.length; i++)
        {
            color = "#" + ntc.names[i][0];
            rgb = ntc.rgb(color);
            hsl = ntc.hsl(color);
            ntc.names[i].push(rgb[0], rgb[1], rgb[2], hsl[0], hsl[1], hsl[2]);
        }
    },

    name: function(color) {
        color = color.toUpperCase();

        if(color.match(/^#[0-9A-Z]{6},#[0-9A-Z]{6}/)) {
            for(var i = 0; i < ntc.names.length; i++)
            {
                if(color == ntc.names[i][0]) {
                    if (Array.isArray(ntc.names[i][1])) {
                        return [ntc.names[i][0], ntc.names[i][1][0], ntc.names[i][1][1], ntc.names[i][1][2]];
                    } else {
                        return [ntc.names[i][0], ntc.names[i][1], ntc.names[i][0], ntc.names[i][0]];
                    }
                }
            }
        }
        if(color.length < 3 || color.length > 7 && !color.match(/^#[0-9A-Z]{6},#[0-9A-Z]{6}/))
            return ["#000000", "Invalid Color: " + color, false];
        if(color.length % 3 == 0)
            color = "#" + color;
        if(color.length == 4)
            color = "#" + color.substr(1, 1) + color.substr(1, 1) + color.substr(2, 1) + color.substr(2, 1) + color.substr(3, 1) + color.substr(3, 1);

        var rgb = ntc.rgb(color);
        var r = rgb[0], g = rgb[1], b = rgb[2];
        var hsl = ntc.hsl(color);
        var h = hsl[0], s = hsl[1], l = hsl[2];
        var ndf1 = 0, ndf2 = 0, ndf = 0;
        var cl = -1, df = -1;

        for(var i = 0; i < ntc.names.length; i++)
        {
            if(color == "#" + ntc.names[i][0]) {
                if(Array.isArray(ntc.names[i][1])) {
                    return ["#" + ntc.names[i][0], ntc.names[i][1][0], ntc.names[i][1][1], ntc.names[i][1][2]];
                } else {
                    return ["#" + ntc.names[i][0], ntc.names[i][1], "#" + ntc.names[i][0], "#" + ntc.names[i][0]];
                }
            }

            ndf1 = Math.pow(r - ntc.names[i][2], 2) + Math.pow(g - ntc.names[i][3], 2) + Math.pow(b - ntc.names[i][4], 2);
            ndf2 = Math.pow(h - ntc.names[i][5], 2) + Math.pow(s - ntc.names[i][6], 2) + Math.pow(l - ntc.names[i][7], 2);
            ndf = ndf1 + ndf2 * 2;
            if(df < 0 || df > ndf)
            {
                df = ndf;
                cl = i;
            }
        }

        if(cl < 0) {
            return ["#000000", "Invalid Color: " + color, false];

        } else {
            if(Array.isArray(ntc.names[cl][1])) {
                return ["#" + ntc.names[cl][0], ntc.names[cl][1][0], ntc.names[cl][1][1], ntc.names[cl][1][2]];
            } else {
                return ["#" + ntc.names[cl][0], ntc.names[cl][1], "#" + ntc.names[cl][0], "#" + ntc.names[cl][0]];
            }
        }
        // return (cl < 0 ? ["#000000", "Invalid Color: " + color, false] : ["#" + ntc.names[cl][0], ntc.names[cl][1], false]);
    },

    // adopted from: Farbtastic 1.2
    // http://acko.net/dev/farbtastic
    hsl: function (color) {

        var rgb = [parseInt('0x' + color.substring(1, 3)) / 255, parseInt('0x' + color.substring(3, 5)) / 255, parseInt('0x' + color.substring(5, 7)) / 255];
        var min, max, delta, h, s, l;
        var r = rgb[0], g = rgb[1], b = rgb[2];

        min = Math.min(r, Math.min(g, b));
        max = Math.max(r, Math.max(g, b));
        delta = max - min;
        l = (min + max) / 2;

        s = 0;
        if(l > 0 && l < 1)
            s = delta / (l < 0.5 ? (2 * l) : (2 - 2 * l));

        h = 0;
        if(delta > 0)
        {
            if (max == r && max != g) h += (g - b) / delta;
            if (max == g && max != b) h += (2 + (b - r) / delta);
            if (max == b && max != r) h += (4 + (r - g) / delta);
            h /= 6;
        }
        return [parseInt(h * 255), parseInt(s * 255), parseInt(l * 255)];
    },

    // adopted from: Farbtastic 1.2
    // http://acko.net/dev/farbtastic
    rgb: function(color) {
        return [parseInt('0x' + color.substring(1, 3)), parseInt('0x' + color.substring(3, 5)),  parseInt('0x' + color.substring(5, 7))];
    },

    names: [
        ['2F4F4F',['Antique forest', 'Antique forest', 'Antique forest']],
        ['DBC6A5',['Beige travertine', 'Beige travertine', 'Beige travertine']],
        ['4A5553',['Black slate', 'Black slate', 'Black slate']],
        ['483D8B',['Blue stone', 'Blue stone', 'Blue stone']],
        ['4B0082',['Blue stone matt', 'Blue stone matt', 'Blue stone matt']],
        ['DCDCDC',['Carrara', 'Carrara', 'Carrara']],
        ['F8F8FF',['Crystal white', 'Crystal white', 'Crystal white']],
        ['00008B',['Dark blue matt', 'Dark blue matt', 'Dark blue matt']],
        ['F5DEB3',['Galala matt', 'Galala matt', 'Galala matt']],
        ['DAA520',['Honey onyx', 'Honey onyx', 'Honey onyx']],
        ['8FBC8F',['Light grey', 'Light grey', 'Light grey']],
        ['191970',['Moon stone', 'Moon stone', 'Moon stone']],
        ['F5F5F5',['White marble', 'White marble', 'White marble']],
        ['FFF5EE',['White marble hunan', 'White marble hunan', 'White marble hunan']],
        ['D0C3BE',['Anemon', 'Анемон', 'Anemon']],
        ['45464C',['Antracit', 'Антрацит', 'Antracit']],
        ['383E42',['Anthracite mat', 'Антрацит мат', 'Anthracite mat']],
        ['5F6A6A,#FFFFFF',['Antracit, alb', 'Антрацит, белый', 'Antracit, alb']],
        ['F2E7BF',['Bahama', 'Багама', 'Bahama']],
        ['575D5E',['Basalt mat', 'Базальт мат', 'Basalt mat']],
        ['F5F5DC,#FFFFFF',['Bej, alb', 'Беж, белый', 'Bej, alb']],
        ['F5F5DC',['Bej', 'Бежевый', 'Bej']],
        ['DDA46E',['Bej bahama', 'Бежевый багама', 'Bej bahama']],
        ['B37700',['Jurassic bej', 'Бежевый юрский', 'Jurassic bej']],
        ['FFFFFF',['Alb', 'Белый', 'Aalb']],
        ['F4F6F7',['Alb mat', 'Белый мат ', 'Alb mat']],
        ['#F8F9F9,#FFFFFF',['Alb structurat, alb', 'Белый структурный, белый', 'Alb structurat, alb']],
        ['#FFFFFF,#5F6A6A',['Alb, antracit', 'Белый, антрацит', 'Alb, antracit']],
        ['#FFFFFF,#F5F5DC',['Alb, bej, gri', 'Белый, бежевый, серый', 'Alb, bej, gri']],
        ['#FFFFFF,#F8F9F9',['Alb, alb structurat', 'Белый, белый структурный', 'Alb, alb structurat']],
        ['#FFFFFF,#A79A91',['Alb, cappuccino', 'Белый, капучино', 'Alb, cappuccino']],
        ['#FFFFFF,#FFFDD0',['Alb, cremă', 'Белый, крем', 'Alb, cremă']],
        ['#FFFFFF,#C1B3A8',['Alb, polilac deschis', 'Белый, светлый полилак', 'Alb, polilac deschis']],
        ['#FFFFFF,#DCB491',['Alb, sonoma', 'Белый, сонома', 'Alb, sonoma']],
        ['#FFFFFF,#CEC1B8',['Alb, frasin', 'Белый, ясень', 'Alb, frasin']],
        ['#FFFFFF,#C0C0C0',['Alb cromat', 'Белый-хром', 'Alb cromat']],
        ['686C5E',['Beton-gri', 'Бетонно-серый', 'Beton-gri']],
        ['#F2F4F4,#A79A91',['Bismarck white, cappuccino', 'Бисмарк white, капучино', 'Bismarck white, cappuccino']],
        ['664400',['Bronz', 'Бронза', 'Bronz']],
        ['8B4513',['Bronz', 'Бронза', 'Bronz']],
        ['F3E5AB',['Vanilie', 'Ваниль', 'Vanilie']],
        ['#DFDDDE,#FFFFFF',['Vintage, alb', 'Винтаж, белый', 'Vintage, alb']],
        ['E6FFFF',['Albastru deschis', 'Голубой', 'Albastru deschis']],
        ['#654321,#FFFFFF',['Stejar fascari, alb', 'Дуб фаскари, белый', 'Stejar fascari, alb']],
        ['F8DE7E',['Iasomie', 'Жасмин', 'Iasomie']],
        ['FFFF80',['Galben', 'Желтый', 'Galben']],
        ['009933',['Verde', 'Зеленый', 'Verde']],
        ['FFCC33',['Auriu', 'Золотой', 'Auriu']],
        ['#A79A91,#FFFFFF',['Cappuccino, alb', 'Капучино, белый', 'Cappuccino, alb']],
        ['85461E',['Caramel', 'Карамель', 'Caramel']],
        ['4D3024',['Brun-caramiziu', 'Коричнево-карамельный', 'Brun-caramiziu']],
        ['A52A2A',['Maro', 'Коричневый', 'Maro']],
        ['4D2600',['Maro bali', 'Коричневый бали', 'Maro bali']],
        ['A93226',['Roșu', 'Красное', 'Roșu']],
        ['A13D2D',['Maro roșcat', 'Красно-коричневый', 'Maro roșcat']],
        ['FF0000',['Roșu', 'Красный', 'Roșu']],
        ['FFFDD0',['Cream', 'Крем', 'Cream']],
        ['#FFFDD0,#FFFFFF',['Cremă, alb', 'Крем, белый', 'Cremă, alb']],
        ['F3E5D8',['Crem', 'Кремовый', 'Crem']],
        ['E2AF80',['Manhattan', 'Манхэттен', 'Manhattan']],
        ['FFFFE0',['Mată', 'Матовый', 'Mată']],
        ['F9E4D2',['Melba', 'Мельба', 'Melba']],
        ['B0C4DE',['Metalic', 'Металл', 'Metalic']],
        ['FFA366,#4D9900,#004D99,#660066',['Mixate', 'Микс', 'Mixate']],
        ['F3C9A5',['Natura', 'Натура', 'Natura']],
        ['FF9900',['Portocaliu', 'Оранжевый', 'Portocaliu']],
        ['#0F0F0F,#FFFFFF',['Parabolic black, alb', 'Параболик black, белый', 'Parabolic black, alb']],
        ['D89562',['Nisip gri', 'Песочно-серый', 'Nisip gri']],
        ['C2B280',['Nisip', 'Песочный', 'Nisip']],
        ['FFFFFF00',['Transparent', 'Прозрачный', 'Transparent']],
        ['FFE6E6',['Roz', 'Розовый', 'Roz']],
        ['F9F9EB',['Bej deschis', 'Светло-бежевый', 'Bej deschis']],
        ['B5651D',['Brun deschis', 'Светло-коричневый', 'Brun deschis']],
        ['D3D3D3',['Gri deschis', 'Светло-серый', 'Gri deschis']],
        ['#C1B3A8,#FFFFFF',['Polilac deschis, alb', 'Светлый полилак, белый', 'Polilac deschis, alb']],
        ['8F999F',['Argintiu', 'Серебристо-серый', 'Argintiu']],
        ['C0C0C0',['Argintiu', 'Серебристый', 'Argintiu']],
        ['F0F0F5',['Argintiu', 'Серебро', 'Argintiu']],
        ['808080',['Gri', 'Серый', 'Gri']],
        ['A0522D',['Siena', 'Сиена', 'Siena']],
        ['0073E6',['Albastru', 'Синий', 'Albastru']],
        ['1E90FF',['Albastru', 'Синий', 'Albastru']],
        ['6C5C4F',['Polilac închis', 'Темный полилак', 'Polilac închis']],
        ['#6C5C4F,#FFFFFF',['Polilac închis, alb', 'Темный полилак, белый', 'Polilac închis, alb']],
        ['755139',['Toffi', 'Тоффи', 'Toffi']],
        ['8A7E66',['Umbra', 'Умбра', 'Umbra']],
        ['660066',['Violet', 'Фиолетовый', 'Violet']],
        ['#C0C0C0,#000000',['Crom/negru', 'Хром/черный', 'Crom/negru']],
        ['000000',['Negru', 'Черный', 'Negru']],
        ['#3B3B3C,#FFFFFF',['Negru lucios, alb', 'Черный глянец, белый', 'Negru lucios, alb']],
        ['#0000FF,#FFFFFF',['Perlă neagră, alb', 'Черный жемчуг, белый', 'Perlă neagră, alb']],
        ['#000000,#FFFFFF',['Negru/alb', 'Черный/белый', 'Negru/alb']],
        ['#000000,#C0C0C0',['Negru cromat', 'Черный-хром', 'Negru cromat']],
        ['D2691E',['Ciocolata', 'Шоколад', 'Ciocolata']],
        ['CEC1B8',['Frasin', 'Ясень', 'Frasin']],
    ]
};

ntc.init();

export default ntc;
