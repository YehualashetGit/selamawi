/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
package selamawi;

/**
 *
 * @author yehualahset
 */

import org.junit.runner.JUnitCore;
import org.openqa.selenium.WebDriver;

public class Selamawi {

    /**
     * @param args the command line arguments
     */
    public static WebDriver driver;
    public static void main(String[] args) {
        // TODO code application logic here
//        System.setProperty("webdriver.chrome.driver", "/usr/local/share/chromedriver");
//        ChromeOptions options = new ChromeOptions();
//        driver = new ChromeDriver();
//        driver.get("http://localhost/selamawi/");
        
        org.junit.runner.Result result = JUnitCore.runClasses(LoginTest.class);
//        org.junit.runner.Result result = JUnitCore.runClasses(CreatePetitonSuite.class);
        
        
        for (org.junit.runner.notification.Failure failure : result.getFailures()) 
        {
           System.out.println(failure.toString());
        }
        System.out.println(result.wasSuccessful());
        
    }
    
}
