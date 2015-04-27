import dispatcher from './lib/dispatcher';

export function setItems(items:array) {
    dispatcher.dispatch(setItems, items);
}

export function setItemTypes(itemTypes:array) {
    dispatcher.dispatch(setItemTypes, itemTypes);
}

export function setGains(gains:array) {
    dispatcher.dispatch(setGains, gains);
}

export function setGainTypes(gainTypes:array) {
    dispatcher.dispatch(setGainTypes, gainTypes);
}

export function set(key, value) {
    switch (key) {
        case 'items':
            setItems(value);
            break;

        case 'itemTypes':
            setItemTypes(value);
            break;

        case 'gains':
            setGains(value);
            break;

        case 'gainTypes':
            setGainTypes(value);
            break;
    }
}