import { Link } from "react-router-dom";
import "./Navbar.css"; // Opcional: para estilização
import Logo from "../../assets/images/logo.png";

function Navbar() {
  return (
    <nav className="menu">
      <ul>
        <li>
          <Link to="/">Listagem</Link>
        </li>
        <li>
          <Link to="/cadastrar">Cadastrar</Link>
        </li>
      </ul>
    </nav>
  );
}

export default Navbar;
