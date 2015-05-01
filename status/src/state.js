import Immutable from 'immutable';
import $ from 'jquery-browserify';
import State from './lib/state';
import * as actions from './actions';
import Loader from './services/loader';

function extendsJson(json, extend) {
    return $.extend(true, {}, json, extend);
}

const now = new Date();
const currentDay = {
    day: now.getDate(),
    month: now.getMonth() + 1,
    year: now.getFullYear(),
};
const timeFrom = extendsJson(currentDay, {day: 1, hour: 0, minute: 0});
const timeTo = extendsJson(currentDay, {hour: now.getHours(), minute: now.getMinutes()});

const basicData = Immutable.fromJS({
    items: {
        items: [],
        itemTypes: [],
    },
    gains: {
        gains: [],
        gainTypes: [],
    },
    filters: {
        selectedTimeFrom: timeFrom,
        selectedTimeTo: timeTo,
        selectedItemTypeId: 0,
    }
});

const appState = new State(basicData);

export default appState;
export const state = appState;

export const itemsCursor = appState.cursor(['items']);
export const gainsCursor = appState.cursor(['gains']);
export const filtersCursor = appState.cursor(['filters']);

export const reload = (key, url) => {
    Loader.loadJson(url, (response) => {
        actions.set(key, response);
    });
};