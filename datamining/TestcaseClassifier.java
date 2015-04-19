import java.io.BufferedReader;
import java.io.BufferedWriter;
import java.io.FileReader;
import java.io.FileWriter;

import weka.classifiers.bayes.NaiveBayes;
import weka.core.Instances;

/**
 * This example trains NaiveBayes incrementally on data obtained
 * from the ArffLoader.
 *
 * @author FracPete (fracpete at waikato dot ac dot nz)
 */
public class TestcaseClassifier {

  /**
   * Expects an ARFF file as first argument (class attribute is assumed
   * to be the last attribute).
   *
   * @param args        the commandline arguments
   * @throws Exception  if something goes wrong
   */
  public static void main(String[] args) throws Exception {
    // load data
	BufferedReader breader = null;
	breader = new BufferedReader(new FileReader("test.arff"));
	BufferedWriter writer = new BufferedWriter(new FileWriter("labeled.arff"));
    Instances train = new Instances(breader);
    train.setClassIndex(train.numAttributes() - 1);
    breader.close();
    
    // train NaiveBayes
    NaiveBayes nb = new NaiveBayes();
    nb.buildClassifier(train);
	
	Instances unlabeled = new Instances(new BufferedReader(new FileReader("unlabeled.arff")));
 
	 // set class attribute
	 unlabeled.setClassIndex(unlabeled.numAttributes() - 1);
	 
	 for (int i = 0; i < unlabeled.numInstances(); i++) {
	   double[] prob = nb.distributionForInstance(unlabeled.instance(i));
	   for (int j=0; j<prob.length; j++){
		   writer.write(train.attribute(train.numAttributes() - 1).value(j)+ "\t" +prob[j]);
		   writer.newLine();
	   }
	   writer.newLine();
	 }
	 
	 writer.flush();
	 writer.close();
  }
}