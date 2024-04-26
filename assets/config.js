const HostnameAndPort = location.port != "80" || location.port != "443" ? `${location.hostname}:${location.port}` : location.hostname;
export const endpoint = {
    'assets' : `${location.protocol}//${HostnameAndPort}/assets`,
    'profil' : `${location.protocol}//${HostnameAndPort}/profil`,
    'img' : `${location.protocol}//${HostnameAndPort}/img`,
}