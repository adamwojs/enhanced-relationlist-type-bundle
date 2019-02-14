import { Component } from 'react';
const PropTypes = require('prop-types');

export default class BaseAttributeComponent extends Component {
    static getEmptyValue() {
        return null;
    }

    componentDidUpdate(nextProps, nextState) {
        if (this.state.value !== nextState.value) {
            this.props.updateRowAttribute(this.props.rowIndex, this.props.identifier, this.state.value);
        }
    }
}

BaseAttributeComponent.propTypes = {
    updateRowAttribute: PropTypes.func.required,
    rowIndex: PropTypes.number.required,
    identifier: PropTypes.string.required,
};
