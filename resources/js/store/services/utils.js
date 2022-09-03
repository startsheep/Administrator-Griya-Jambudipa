const Utils = {
    formatRupiah(angka, prefix) {
        let number_string = angka.toString(),
            split = number_string.split(','),
            sisa = split[0].length % 3,
            rupiah = split[0].substr(0, sisa),
            ribuan = split[0].substr(sisa).match(/\d{3}/gi);

        if (ribuan) {
            let separator = sisa ? '.' : '';
            rupiah += separator + ribuan.join('.');
        }

        rupiah = split[1] != undefined ? rupiah + ',' + split[1] : rupiah;
        return prefix == undefined ? rupiah : (rupiah ? 'Rp. ' + rupiah : '');
    },
    parseRupiah(rupiah) {
        return parseInt(rupiah.replace(/[^0-9]/g, ''));
    },
    checkExtensionImage(file){
        const allowedExtensions =['image/jpg', 'image/png', 'image/jpeg']
        return allowedExtensions.includes(file);
    },
    parseHtmlFromEditor(html){
        return html.replace(/<[^>]*>/g, '');
    },
    formatNumberToRoman(num){
        if (typeof num !== 'number')
            return false;
        var digits = String(+num).split(""),
            key = ["","C","CC","CCC","CD","D","DC","DCC","DCCC","CM",
                "","X","XX","XXX","XL","L","LX","LXX","LXXX","XC",
                "","I","II","III","IV","V","VI","VII","VIII","IX"],
            roman_num = "",
            i = 3;
        while (i--)
            roman_num = (key[+digits.pop() + (i * 10)] || "") + roman_num;
        return Array(+digits.join("") + 1).join("M") + roman_num;

    }


}
export default Utils
