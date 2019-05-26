import moment from 'moment'

export function formatCurrency (number, options) {
    if (number && options) {
        return Intl.NumberFormat(
            options.locale,
            {
                style: 'currency',
                currency: options.code
            }
        ).format(number)
    }
}

export function formatDate (value, format) {
    if (value && format) {
        return moment(String(value)).format(format)
    }
}
