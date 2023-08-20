import React from 'react'
import { Link } from 'react-router-dom'
import AuthUser from '../Context/Auth'

export default function Header() {

  const { token, logout } = AuthUser()
  const { user } = AuthUser()
  const { getToken } = AuthUser()
  const isLoggedIn = !!getToken()


  const logoutUser = () => {
    if ( token != undefined ){
      logout()
    }
  }

  return (
    <header className="flex items-center justify-between p-5 bg-white shadow-md">
      <div>
        <Link to="/">
          <h1 className="text-4xl">LOGO HERE</h1>
        </Link>
        
      </div>
      
      <div className="flex items-center justify-center">
        {
          !isLoggedIn ? 
          <div>
            <Link className="mx-5 font-bold" to="/">
              Home
            </Link>
            <Link to="/auth" className="mx-5 font-bold">
              Sign in
            </Link>
          </div>
          : 
          <div className="flex items-center ">
            <p className="mx-4 text-lg">Welcome {user.name}</p>
            <button onClick={logoutUser} className="mx-5 font-bold">Logout</button>
          </div>
        }
        

        
        
      </div>
    </header>
  )
}
