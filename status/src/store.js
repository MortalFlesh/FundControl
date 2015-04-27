import * as actions from './actions';
import {itemsCursor, gainsCursor} from './state';
import dispatcher from './lib/dispatcher';
import {List, Record} from 'immutable';
import $ from 'jquery-browserify';

const Type = new Record({
    id: 0,
    name: '',
});

const ItemRecord = new Record({
    name: '',
    itemType: new Type(),
    amount: 0,
    time: {
        day: 0,
        month: 0,
        year: 0,
        hour: 0,
        minute: 0,
        second: 0,
    }
});

const GainRecord = new Record({
    name: '',
    gainType: new Type(),
    amount: 0,
    time: {
        day: 0,
        month: 0,
        year: 0,
        hour: 0,
        minute: 0,
        second: 0,
    }
});

export const dispatchToken = dispatcher.register(({action, data}) => {
    switch(action) {
        case actions.setItems:
            let items = new List();

            $.each(data, (i, value) => {
                items = items.push(new ItemRecord(value).toMap());
            });

            setToItemsCursor('items', items);
            break;
        
        case actions.setItemTypes:
            let itemTypes = new List();

            $.each(data, (i, value) => {
                itemTypes = itemTypes.push(new Type(value).toMap());
            });

            setToItemsCursor('itemTypes', itemTypes);
            break;
        
        case actions.setGains:
            let gains = new List();

            $.each(data, (i, value) => {
                gains = gains.push(new GainRecord(value).toMap());
            });

            setToGainsCursor('gains', gains);
            break;
        
        case actions.setGainTypes:
            let gainTypes = new List();

            $.each(data, (i, value) => {
                gainTypes = gainTypes.push(new Type(value).toMap());
            });

            setToGainsCursor('gainTypes', gainTypes);
            break;
    }
});

function setToItemsCursor(key, value) {
    itemsCursor((items) => items.set(key, value));
}

function setToGainsCursor(key, value) {
    gainsCursor((gains) => gains.set(key, value));
}

export function getItems() {
    return itemsCursor().get('items');
}

export function getItemTypes() {
    return itemsCursor().get('itemTypes');
}

export function getGains() {
    return gainsCursor().get('gains');
}

export function getGainTypes() {
    return gainsCursor().get('gainTypes');
}
