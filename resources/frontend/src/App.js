import logo from './logo.svg';
import './App.css';
import {BrowserRouter as Router, Routes, Route, Navigate} from "react-router-dom";
import Dashboard from './Pages/Dashboard';
import Auth from './Pages/Auth';
import AuthUser from './Context/Auth';


function App() {

  const { getToken } = AuthUser()
  const isLoggedIn = !!getToken()


  return (
    <div className="App">
      <Routes>
        <Route exact path="/auth" element={isLoggedIn ? <Navigate to="/" /> : <Auth />} />
        <Route exact path="/" element={isLoggedIn ? <Dashboard /> : <Navigate to="/auth" />} />
      </Routes>
    </div>
  );
  }


export default App;
