import { handleResponse } from '../_helpers/handleResponse';

export const connectionService = {
    getList,
    updateOrCreate,
    remove,
};

/**
 * @param updateStatus
 * @returns {Promise<Response>}
 */
function getList(updateStatus) {

    let status = updateStatus ? 1 : 0;

    return fetch(`/api/configuration?updateStatus=` + status)
        .then(handleResponse)
        .then(data => {

            return data;
        });
}

/**
 * @param configurations
 * @returns {Promise<Response>}
 */
function updateOrCreate(configurations) {

    const requestOptions = {
        method: 'POST',
        headers: {
            'Accept': 'application/json',
            'Content-type': 'application/json',
        },
        body: JSON.stringify(configurations)
    };

    return fetch(`/api/configuration`, requestOptions)
        .then(handleResponse)
        .then(data => {

            return data;
        });
}

/**
 * @param uuid
 * @returns {Promise<Response>}
 */
function remove(uuid) {

    const requestOptions = {
        method: 'DELETE',
        headers: {
            'Accept': 'application/json',
        }
    };

    return fetch(`/api/configuration/` + uuid, requestOptions)
        .then(handleResponse)
        .then(data => {

            return data;
        });
}
