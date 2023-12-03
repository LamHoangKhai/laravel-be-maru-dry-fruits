const Mydebounce = (callback, timeout = 500) => {
    let timer;
    return (...agrs) => {
        clearTimeout(timer);
        timer = setTimeout(() => {
            callback.apply(this, agrs);
        }, timeout);
    };
};
export default Mydebounce;
