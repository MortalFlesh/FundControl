import Immutable from 'immutable';
import State from './lib/state';
import * as actions from './actions';
import Loader from './services/loader';

const basicData = Immutable.fromJS({
    items: {
        items: [],
        itemTypes: [],
    },
    gains: {
        gains: [],
        gainTypes: [],
    },
});

const appState = new State(basicData);

export default appState;
export const state = appState;

export const itemsCursor = appState.cursor(['items']);
export const gainsCursor = appState.cursor(['gains']);

export const reload = (key, url) => {
    Loader.loadJson(url, (response) => {
        actions.set(key, response);
    });
};