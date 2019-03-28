import {Component} from '../generic';
import iconMovie from '../partials/iconMovie';

class Header extends Component {
    shouldUpdate() {
        return false;
    }

    render() {
        return (
            `<header class="header">
                <div class="header__wrapper wrapper wrapper--constrained">
                    <a href="/" class="header__title"><span class="header__logo">${iconMovie()}</span> <span>Kaplunk</span></a>
<br>
<p align="right">
<a href="logout.php">Log Out</a>
</p>
<a href="http://25.44.217.166/IT490-C.E.N.P/Table_Responsive_v2">Watchlist</a>
                </div>
            </header>`
        );
    }
}

export default Header;
