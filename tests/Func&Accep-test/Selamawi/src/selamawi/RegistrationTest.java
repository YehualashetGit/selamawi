/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
package selamawi;

import static java.lang.Thread.sleep;
import java.util.logging.Level;
import java.util.logging.Logger;
import org.junit.AfterClass;
import org.junit.BeforeClass;
import org.junit.Test;
import org.openqa.selenium.By;
import org.openqa.selenium.WebDriver;
import org.openqa.selenium.WebElement;
import org.openqa.selenium.chrome.ChromeDriver;
import org.testng.Assert;

/**
 *
 * @author yehualahset
 */
public class RegistrationTest {
    
    private static WebDriver driver;
    private static WebElement password,passConf,email,element;
    
    @BeforeClass
    public static void setup()
    {
         System.setProperty("webdriver.chrome.driver", "/usr/local/share/chromedriver");
         driver= new ChromeDriver();
         driver.get("http://localhost/selamawi/");
         
    }
    
    @Test
    public void testRegistration()
    {
        String inputEmail="yehuala5355@gmail.com";
        String inputPass="pass5";
        
        email=driver.findElement(By.name("reg_email"));
        password=driver.findElement(By.name("reg_pass"));
        passConf=driver.findElement(By.name("reg_pass_conf"));
        email.sendKeys(inputEmail);
        password.sendKeys(inputPass);
        passConf.sendKeys(inputPass);
        passConf.submit();
        
        try{
            element=driver.findElement(By.xpath("//*[@id=\"elems\"]/li[5]/a/img"));
        }   
        catch(Exception e)
        {
            
        }
        Assert.assertNotNull(element);
        System.out.println("Ending test "+new Object(){}.getClass().getEnclosingMethod());
        
        
       
    }
    public void _sleep() 
    {
        try {
            sleep(2000);
        } catch (InterruptedException ex) {
            Logger.getLogger(LoginTest.class.getName()).log(Level.SEVERE, null, ex);
        }
    }
    
    @AfterClass
    public static void cleanUp()
    {
        if(driver != null)
        {
            driver.close();
            driver.quit();
        }
    }
    
    
}
