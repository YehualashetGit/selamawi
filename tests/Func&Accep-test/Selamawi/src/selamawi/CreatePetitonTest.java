/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
package selamawi;

import static java.lang.Thread.sleep;
import java.util.List;
import java.util.Scanner;
import java.util.logging.Level;
import java.util.logging.Logger;
import org.junit.AfterClass;
import org.junit.Test;
import org.openqa.selenium.By;
import org.openqa.selenium.WebDriver;
import org.openqa.selenium.WebElement;
import org.openqa.selenium.chrome.ChromeDriver;
import org.openqa.selenium.support.ui.Select;
import org.testng.Assert;
import org.testng.annotations.BeforeTest;

/**
 *
 * @author yehualahset
 */
public class CreatePetitonTest {
    
    private static WebDriver driver;
    private static WebElement username,description,password;
    
    
    Scanner input=new Scanner(System.in);
    @BeforeTest
    public static void setup()
    {
        System.setProperty("webdriver.chrome.driver", "/usr/local/share/chromedriver");
         driver= new ChromeDriver();
         driver.get("http://localhost/selamawi/");
         
    }
    
    @Test
    public void testCreate()
    {
        login();
        
        System.out.print("Enter user name or ID: ");
        String name=input.nextLine();
        System.out.print("Enter password:");
        String pass=input.nextLine();
        
        
        String petTitle,petDesc,petRec;
        petTitle="This is the test title for testing";
        
        petDesc="Film festivals used to be do-or-die moments for movie makers. "
                + "They were where you met the producers that could fund your project,"
                + " and if the buyers liked your flick, "
                + "they’d pay to Fast-forward and…"
                + " Read More"
                + "Film festivals used to be "
                + "do-or-die moments for movie makers.";
        petRec="yehuala5355@gmail.com";
        username=driver.findElement(By.name("log_username"));
        username.sendKeys(name);
        password=driver.findElement(By.name("log_password"));
        password.sendKeys(pass);
        password.submit();
        WebElement  title,dicription,reciver;
        title=driver.findElement(By.name("pet_title"));
//        List<WebElement> selected=new Select(driver.findElement(By.name("pet_tags[]"))).getOptions();
            Select dropdown=new Select(driver.findElement(By.name("pet_tags[]")));
            dropdown.selectByVisibleText("software engineering");
        dicription=driver.findElement(By.name("pet_desc"));
        reciver=driver.findElement(By.name("pet_to"));
        title.sendKeys(petTitle);
        description.sendKeys(petDesc);
        reciver.sendKeys(petRec);
        driver.findElement(By.name("pet_sub")).click();
        Assert.assertTrue(true);
    }
    public  void login()
    {
        String name="atr/4554/07";
        String pass="pass";
        username=driver.findElement(By.name("log_username"));
        username.sendKeys(name);
        password=driver.findElement(By.name("log_password"));
        password.sendKeys(pass);
        password.submit();
        
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
