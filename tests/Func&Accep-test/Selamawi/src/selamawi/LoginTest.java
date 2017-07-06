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
import org.openqa.selenium.support.ui.Select;
import org.openqa.selenium.support.ui.WebDriverWait;
import org.testng.Assert;
import static java.lang.Thread.sleep;
import java.util.Scanner;

/**
 *
 * @author yehualahset
 */
public class LoginTest {
    
    private static WebDriver driver;
    private static WebElement username,password,element;
    
    Scanner input=new Scanner(System.in);
    @BeforeClass
    public static void setup()
    {
         System.setProperty("webdriver.chrome.driver", "/usr/local/share/chromedriver");
         driver= new ChromeDriver();
         driver.get("http://localhost/selamawi/");
         
         
    }
    
    @Test
    public void testLoginwithTrueData()
    {
        System.out.print("Enter user name or ID: ");
        String name=input.nextLine();
        System.out.print("Enter password:");
        String pass=input.nextLine();
        username=driver.findElement(By.name("log_username"));
        username.sendKeys(name);
        password=driver.findElement(By.name("log_password"));
        password.sendKeys(pass);
        password.submit();
        _sleep();
        try{
            element=driver.findElement(By.xpath("//*[@id=\"elems\"]/li[5]/a/img"));
        }
        catch(Exception e)
        {
            
        }
        Assert.assertNotNull(element);
        System.out.println("Ending test "+new Object(){}.getClass().getEnclosingMethod());
        
    }
    
    @Test
    public void testCreatePetiton()
    {
//        login();
//        String name="atr/9889/07";
//        String pass="pass";
//        
        System.out.println("starting test "+ new Object(){}.getClass().getEnclosingMethod());
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
//        username=driver.findElement(By.name("log_username"));
//        username.sendKeys(name);
//        password=driver.findElement(By.name("log_password"));
//        password.sendKeys(pass);
//        password.submit();
        WebElement  title,dicription,reciver,search;
        title=driver.findElement(By.name("pet_title"));
//        List<WebElement> selected=new Select(driver.findElement(By.name("pet_tags[]"))).getOptions();
            Select dropdown=new Select(driver.findElement(By.name("pet_tags[]")));
            dropdown.selectByVisibleText("software engineering");
        dicription=driver.findElement(By.name("pet_desc"));
        reciver=driver.findElement(By.name("pet_to"));
        
        title.sendKeys(petTitle);
        dicription.sendKeys(petDesc);
        driver.findElement(By.xpath("//*[@id=\"pet_create\"]/input[5]")).click();
        reciver.sendKeys(petRec);
        
        _sleep();
        
        driver.findElement(By.name("pet_sub")).click();
        driver.navigate().to("http://localhost/selamawi/account.php");
        search=driver.findElement(By.name("pet_search"));
        search.sendKeys(petTitle);
        search.submit();
        _sleep();
        try
        {
            element.findElement(By.xpath("/html/body/div[1]/div/div"));
        }
        catch(Exception e)
        {
            
        }
        Assert.assertNotNull(element);
        System.out.println("Ending test "+new Object(){}.getClass().getEnclosingMethod());
        
        
    }
    
    @Test
    public void testChangePassword()
    {
        System.out.println("starting test "+ new Object(){}.getClass().getEnclosingMethod());
        
        String oPasswoes="pass";
        String nPassword="pass5";
        driver.findElement(By.xpath("//*[@id=\"elems\"]/li[4]/a/img")).click();
        WebElement oldPass,newPass,confPass;
        oldPass=driver.findElement(By.name("set_opassword"));
        newPass=driver.findElement(By.name("set_npassword"));
        confPass=driver.findElement(By.name("set_cpassword"));
        System.out.println("Enter the old password");
        String oldPassInput=input.nextLine();
        System.out.println("Enter the new password");
        String newPassInput=input.nextLine();
        oldPass.sendKeys(oldPassInput);
        newPass.sendKeys(newPassInput);
        confPass.sendKeys(newPassInput);
        _sleep();
        
        driver.findElement(By.xpath("/html/body/div/div[2]/form/input[5]")).click();
        driver.findElement(By.xpath("//*[@id=\"elems\"]/li[5]/a/img")).click();
        
        WebElement usenamme,pass;
        usenamme=driver.findElement(By.name("log_username"));
        pass=driver.findElement(By.name("log_password"));
        usenamme.sendKeys("atr/9889/07");
        pass.sendKeys();
        pass.submit();
        
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
