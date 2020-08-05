import { handleResponse } from '../_helpers/handleResponse';

export const connectionService = {
    getList,
    updateOrCreate,
    remove,
};

function getList(updateStatus) {

    const requestOptions = {
        method: 'GET',
        headers: {
            'Accept': 'application/json',
            'Content-type': 'application/json',
        }
    };

    let status = updateStatus ? 1 : 0;

    return fetch(`/api/configuration?updateStatus=` + status)
        .then(handleResponse)
        .then(data => {

            return data;
        });
}

function updateOrCreate(configurations) {

    const requestOptions = {
        method: 'POST',
        headers: {
            'Accept': 'application/json',
            'Content-type': 'application/json',
        },
        body: JSON.stringify(configurations)
    };
    // console.log(requestOptions);
    return fetch(`/api/configuration`, requestOptions)
        .then(handleResponse)
        .then(data => {

            return data;
        });
}

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
