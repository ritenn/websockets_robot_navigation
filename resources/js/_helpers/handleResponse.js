export const handleResponse = (response) => {
    return response.text().then(text => {

        const data = text && JSON.parse(text);

        if (!response.ok) {

            const errorData = data || response.statusText;

            return Promise.reject(JSON.parse(JSON.stringify(errorData)));
        }

        return data;
    });
}
